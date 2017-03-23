<?php

use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{

    public function boot() {

    }

    public function testAddingAnProduct()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $this->json('POST', '/api/product/', ['name' => 'Prodotto da Test'], ['Authorization' => 'Bearer ' . $token])
            ->see('creato');
    }

    public function testReturnSingleProducts()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = $user->products()->first();

        $this->json('GET', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see($product->createdAt)
            ->see($product->id);
    }

    public function testReturnSingleProductsFail()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = $user->products()->first();

        $this->json('GET', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see($product->createdAt)
            ->see($product->id);
    }

    public function testReturnManyProducts()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $this->json('GET', '/api/product', [], ['Authorization' => 'Bearer ' . $token])
            ->see('created_at');
    }

    public function testUpdatingAnProduct()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = $user->products()->first();

        $this->json('PATCH', '/api/product/' . $product->id, ['name' => 'Prodotto Modificato da Test'], ['Authorization' => 'Bearer ' . $token])
            ->see('aggiornato');
    }

    public function testUpdatingAnProductWithANonOwnerUser()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = Product::where('user_id', '!=', $user->id)->first();

        $this->json('DELETE', '/api/product/' . substr($product->id, 0, 20), [], ['Authorization' => 'Bearer ' . $token])
            ->see('item_not_found');
    }

    public function testDeletingAnProductWithWrongToken()
    {
        $user = User::first();

        $anotherUser = Product::where('user_id', '!=', $user->id)->first();

        // from another user
        $token = \JWTAuth::fromUser($anotherUser);

        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see('user_not_found');
    }

    public function testDeletingAnProductWithWrongId()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = Product::where('user_id', '!=', $user->id)->first();

        $this->json('DELETE', '/api/product/' . substr($product->id, 0, 20), [], ['Authorization' => 'Bearer ' . $token])
            ->see('item_not_found');
    }

    public function testDeletingAnProductWithANonOwnerUser()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);

        $product = Product::where('user_id', '!=', $user->id)->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see('This action is unauthorized');
    }

    public function testDeletingAnProduct()
    {
        $user = User::first();

        $token = \JWTAuth::fromUser($user);
        
        $product = $user->products()->first();

        $this->json('DELETE', '/api/product/' . $product->id, [], ['Authorization' => 'Bearer ' . $token])
            ->see('eliminato');
    }

}
