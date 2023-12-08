<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Product extends Component
{
    public $img;
    public $name;
    public $price;
    public $strikethroughPrice;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($img, $name, $price, $strikethroughPrice, $id)
    {
        $this->img = $img;
        $this->name = $name;
        $this->price = $price;
        $this->strikethroughPrice = $strikethroughPrice;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product', [
            'money' => function($price) {
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
        ]);
    }
}
