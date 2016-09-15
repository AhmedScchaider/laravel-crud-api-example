<?php

namespace App\Models;

use App\Models\BaseModel;

class Product extends BaseModel
{

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
    
    public function get($limit, $offset) {
        $products = $this
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $products;
    }

    public static function findOrJsonFail($id) {
        $product = Product::find($id);
        if (!$product) {
            throw new \Exception("Prodotto non trovato (ID:$id).", 4040);
        }

        return $product;
    }

}
