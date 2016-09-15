<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{

    //use DatabaseMigrations;

    public function boot() {
        //Artisan::call('migrate:refresh --seed');
    }

    public function testAddingAnProduct() 
    {
        $token = $this->getToken();

        $this->json('POST', '/api/product/', ['name' => 'Prodotto da Test'], ['Authorization' => 'Bearer ' . $token])
            ->see('creato');
    }

    public function testReturnSingleProducts() 
    {
        $token = $this->getToken();
        $user = \JWTAuth::parseToken()->authenticate();

        $product = $user->products()->first();

        $this->json('GET', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see($product->createdAt)
            ->see($product->id);
    }

    public function testReturnSingleProductsFail() 
    {
        $token = $this->getToken();
        $user = \JWTAuth::parseToken()->authenticate();

        $product = $user->products()->first();

        $this->json('GET', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see($product->createdAt)
            ->see($product->id);
    }

    public function testReturnManyProducts() 
    {
        $token = $this->getToken();

        $this->json('GET', '/api/product', [], ['Authorization' => 'Bearer ' . $token])
            ->see('created_at');
    }

    public function testUpdatingAnProduct() 
    {
        $token = $this->getToken();
        
        $product = $user->products()->first();

        $this->json('PATCH', '/api/product/' . $product->id, ['name' => 'Prodotto Modificato da Test'], ['Authorization' => 'Bearer ' . $token])
            ->see('aggiornato');
    }

    public function testUpdatingAnProductWithANonOwnerUser() 
    {
        $token = $this->getToken();

        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . substr($product->id, 0, 20), [], ['Authorization' => 'Bearer ' . $token])
            ->see('item_not_found');
    }

    public function testDeletingAnProductWithWrongToken() 
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);
        
        $anotherUser = User::where('id', '!=', $user->id)->first();

        $anotherToken = \JWTAuth::fromUser($anotherUser);

        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $anotherToken])
            ->see('This action is unauthorized');
    }

    public function testDeletingAnProductWithoutWrongId() 
    {
        $token = $this->getToken();
        $user = \JWTAuth::parseToken()->authenticate();

        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . substr($product->id, 0, 20), [], ['Authorization' => 'Bearer ' . $token])
            ->see('item_not_found');
    }

    public function testDeletingAnProductWithANonOwnerUser() 
    {
        $token = $this->getToken();
        $user = \JWTAuth::parseToken()->authenticate();

        $product = Product::where('user_id', '!=', $user->id)->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see('item_not_found');
    }

    public function testDeletingAnProduct() 
    {
        $token = $this->getToken();
        $user = \JWTAuth::parseToken()->authenticate();
        
        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see('eliminato');
    }

    public function getToken() 
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        return $token;
    }

}
