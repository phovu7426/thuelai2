<?php

namespace App\Services\Cart;

use Darryldecode\Cart\CartCollection;

class DBStorage
{
    public function has($key)
    {
        return \DB::table('cart_storages')->where('id', $key)->exists();
    }

    public function get($key)
    {
        if($this->has($key)) {
            $cart = \DB::table('cart_storages')->where('id', $key)->first();
            return new CartCollection($cart->cart_data);
        }
        return [];
    }

    public function put($key, $value)
    {
        $cart = ['id' => $key, 'cart_data' => $value];
        
        if($this->has($key)) {
            \DB::table('cart_storages')
                ->where('id', $key)
                ->update($cart);
        } else {
            \DB::table('cart_storages')
                ->insert($cart);
        }
    }
} 