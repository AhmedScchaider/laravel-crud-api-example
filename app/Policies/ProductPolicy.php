<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Product;


class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function show(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }

    public function destroy(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }
}
