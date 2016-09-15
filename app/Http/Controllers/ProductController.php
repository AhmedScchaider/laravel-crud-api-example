<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\ShowProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\DestroyProductRequest;

use App\Helpers\Contracts\SkuContract;
use App\Models\Product;
use App\Models\User;
use Event;
use App\Events\SkuCreatedEvent;
use App\Jobs\SendSkuReport;
use Auth;

class ProductController extends Controller
{

    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }

    public function index(IndexProductRequest $request)
    {
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        $products = new Product();
        $products = $products->get($limit, $offset);

        return response()->json($products);
    }

    public function show(ShowProductRequest $request, $productId) 
    {
        $product = Product::findOrJsonFail($productId);

        $this->authorize('show', $product);

        return response()->json($product);
    }

    public function store(StoreProductRequest $request, SkuContract $skuGenerator) 
    {
        $this->authorize('store-product');

        $user = Auth::user();

        $name = $request->input('name');

        $sku = $skuGenerator->generateSku();
        Event::fire(new SkuCreatedEvent($sku));

        $product = new Product();
        $product->user_id = $user->id;
        $product->name = $name;
        $product->sku = $sku;
        $product->save();

        $adminUser = User::where('email', 'alberto.bravi@gmail.com')->first();
        if ($adminUser) {
            $job = (new SendSkuReport($adminUser))->onQueue('emails');
            $this->dispatch($job);
        }

        return response()->json("Prodotto creato (SKU:$sku).", 200);
    }

    public function update(UpdateProductRequest $request, $productId) {
        $product = Product::findOrJsonFail($productId);

        $this->authorize('update', $product);

        $name = $request->input('name');

        $product->name = $name;
        $product->save();

        return response()->json("Prodotto aggiornato (ID:$productId).", 200);
    }

    public function destroy(DestroyProductRequest $request, $productId) {
        $product = Product::findOrJsonFail($productId);

        $this->authorize('destroy', $product);

        $product->delete();

        return response()->json("Prodotto eliminato (ID:$productId).", 200);            
    }

}
