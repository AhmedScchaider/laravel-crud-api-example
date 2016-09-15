<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        foreach ($users as $user) {
            Product::create([
                'name' => 'Product ' . rand(1, 99999), 
                'user_id' => $user->id, 
                'sku' => str_random(13)
            ]);
        }
    }
}
