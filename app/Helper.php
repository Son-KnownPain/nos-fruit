<?php

namespace App;

use Illuminate\Http\Request;
use App\Models\Product;

class Helper {
    public static function array_find($arr, $callback) {
        for ($i=0; $i < count($arr); $i++) { 
            if ($callback($arr[$i], $i)) {
                return $arr[$i];
            }
        }
    }
    public static function getProductsInCart() {
        $cart = json_decode(request()->cookie('cart'));
        $ids = ($cart != null && !empty($cart)) ? array_map(function($item) {
            return $item->id;
        }, $cart) : [];

        $products = Product::whereIn('id', $ids)->get();
        $result = array();
        foreach ($products as $product) {
            array_push($result, [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discount' => $product->discount,
                'thumbnail' => $product->thumbnail,
                'quantity' => self::array_find($cart, function($item) use ($product) {
                    return $item->id == $product->id;
                })->quantity
            ]);
        }
        
        return $result;
    }

    public static function moneyFormat($price) {
        $price = (string) $price;
        $price = strrev($price);

        $result = '';

        for ($i=0; $i < strlen($price); $i++) { 
            if ($i % 3 == 0 && $i != 0) {
                $result .= '.';
            }

            $result .= $price[$i];
        }

        $result = strrev($result);

        return $result;
    }
}