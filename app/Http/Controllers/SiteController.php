<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Helper;

class SiteController extends Controller
{
    public function index() {
        return view('index', [
            'title' => 'NOS Fruits - Trang chủ'
        ]);
    }

    public function introduce() {
        return view('pages.introduce', [
            'title' => 'NOS Fruits - Giới thiệu'
        ]);
    }

    public function contact() {
        return view('pages.contact', [
            'title' => 'NOS Fruits - Liên hệ'
        ]);
    }

    public function products(Request $request) {
        // Category slug
        $cs = $request->query('c', null);
        $products;
        if ($cs != null) {
            $category = Category::where('slug', '=', $cs)->first();
            if ($category == null) {
                return redirect('/please-enter-correct-category');
            }

            $products = Product::where('category_id', '=', $category->id )->get();
        }        

        return view('pages.products', [
            'title' => 'NOS Fruits - Sản phẩm',
            'products' => $products ?? Product::all()
        ]);
    }

    public function productDetail(Request $request, $id) {
        $product = Product::findOrFail($id);

        return view('pages.product_detail', [
            'title' => 'NOS Fruits - Chi tiết sản phẩm',
            'product' => $product,
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

    public function search(Request $req) {
        $keyword = $req->query('keyword', null);
        if ($keyword == '') {
            return redirect()->back();
        }
        $products;
        if ($keyword != null) {
            $products = Product::where('name', 'LIKE', '%'.$keyword.'%')->get();
        } else {
            return redirect('/');
        }
        return view('pages.products', [
            'title' => 'NOS Fruits - Tìm kiếm sản phẩm',
            'searching' => $keyword,
            'products' => $products ?? []
        ]);
    }

    public function cart() {
        return view('pages.cart', [
            'title' => 'NOS Fruits - Giỏ hàng'
        ]);
    }
    
    public function addToCart(Request $request, $id) {
        if ($request->cookie('cart') == null) {
            return redirect()->back()->withCookie(cookie()->forever('cart', json_encode(
                [
                    [
                        'id' => $id,
                        'quantity' => 1
                    ]
                ]
            )));
        } else {
            $cart = json_decode($request->cookie('cart'), true);
            for ($i=0; $i < count($cart); $i++) { 
                if ($cart[$i]['id'] == $id) {
                    $cart[$i]['quantity'] += 1;
                    return redirect()->back()->withCookie(cookie()->forever('cart', json_encode(
                        $cart
                    )));
                }
            }
            array_push($cart, [
                'id' => $id,
                'quantity' => 1
            ]);
            return redirect()->back()->withCookie(cookie()->forever('cart', json_encode(
                $cart
            )));
        }
    }

    public function addMultiToCart(Request $request, $id) {
        $quantityToAdd = (int) $request->query('q', 1);
        $quantityToAdd = $quantityToAdd >= 1 ? $quantityToAdd : 1;

        $result;

        $product = Product::findOrFail($id);
        if ($product != null) {
            $result = [
                'add' => true,
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantityToAdd,
                    'price' => $product->price - ($product->price * $product->discount),
                    'thumbnail' => $product->thumbnail
                ]
            ];
        } else {
            $result = [
                'add' => false,
                'message' => "That product'id doesn't exist"
            ];
        }

        if ($request->cookie('cart') == null) {
            return response()->json($result)->withCookie(cookie()->forever('cart', json_encode(
                [
                    [
                        'id' => $id,
                        'quantity' => $quantityToAdd
                    ]
                ]
            )));
        } else {
            $cart = json_decode($request->cookie('cart'), true);
            for ($i=0; $i < count($cart); $i++) { 
                if ($cart[$i]['id'] == $id) {
                    $cart[$i]['quantity'] += $quantityToAdd;
                    return response()->json($result)->withCookie(cookie()->forever('cart', json_encode(
                        $cart
                    )));
                }
            }
            array_push($cart, [
                'id' => $id,
                'quantity' => $quantityToAdd
            ]);
            return response()->json($result)->withCookie(cookie()->forever('cart', json_encode(
                $cart
            )));
        }
    }

    public function increaseQuantity(Request $request, $id) {
        if ($request->cookie('cart') == null) {
            return response()->json([
                'change' => false,
                'message' => 'Cart is empty please add product to cart'
            ]);
        } else {
            $cart = json_decode($request->cookie('cart'), true);
            for ($i=0; $i < count($cart); $i++) { 
                if ($cart[$i]['id'] == $id) {
                    $cart[$i]['quantity'] += 1;
                    return response()->json([
                        'change' => true
                    ])->withCookie(cookie()->forever('cart', json_encode(
                        $cart
                    )));
                }
            }

            return response()->json([
                'change' => false,
                'message' => 'That product non exist in cart'
            ]);
        }
    }

    public function decreaseQuantity(Request $request, $id) {
        if ($request->cookie('cart') == null) {
            return response()->json([
                'change' => false,
                'message' => 'Cart is empty please add product to cart'
            ]);
        } else {
            $cart = json_decode($request->cookie('cart'), true);
            for ($i=0; $i < count($cart); $i++) { 
                if ($cart[$i]['id'] == $id) {
                    if ($cart[$i]['quantity'] > 1) {
                        $cart[$i]['quantity'] -= 1;
                    } else {
                        return response()->json([
                            'change' => false,
                            'message' => 'Quantity is 1, you cannot decrease'
                        ]);
                    }
                    return response()->json([
                        'change' => true
                    ])->withCookie(cookie()->forever('cart', json_encode(
                        $cart
                    )));
                }
            }

            return response()->json([
                'change' => false,
                'message' => 'That product non exist in cart'
            ]);
        }
    }

    public function delete(Request $request, $id) {
        function my_filter($arr, $callback) {
            $newArr = array();
            $index = 0;
            for ($i=0; $i < count($arr); $i++) { 
                if ($callback($arr[$i], $i, $arr)) {
                    $newArr[$index] = $arr[$i];
                    $index++;
                }
            }

            return $newArr;
        }
        if ($request->cookie('cart') == null) {
            return response()->json([
                'change' => false,
                'message' => 'Cart is empty please add product to cart'
            ]);
        } else {
            $cart = json_decode($request->cookie('cart'), true);
            
            $cart = my_filter($cart, function($item) use ($id) {
                return $item['id'] != $id;
            });

            return response()->json([
                'change' => true
            ])->withCookie(cookie()->forever('cart', json_encode(
                $cart
            )));
        }
    }

    public function login() {
        return view('pages.login', [
            'title' =>  'NOS Fruits - Đăng nhập'
        ]);
    }

    public function register() {
        return view('pages.register', [
            'title' => 'NOS Fruits - Đăng ký'
        ]);
    }

    public function checkout(Request $request) {

        if ($request->session()->has('cart')) {
            $cartSession = $request->session()->get('cart');
            $request->session()->forget('cart');
            $request->session()->flash('cart', $cartSession);
        }

        $cartSession = Helper::getProductsInCart();

        if (!empty($cartSession)) {
            $request->session()->flash('cart', $cartSession);
        }

        return view('pages.checkout', [
            'title' => 'NOS Fruits - Tiến hành đặt hàng'
        ]);
    }

    public function checkoutConfirm(Request $request) {
        $validated = $request->validate([
            'phone' => 'required|numeric|digits:10'
        ]);

        if($request->session()->has('cart')) {
            $data = $request->input();
            $productsToOrder = $request->session()->get('cart');

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'entered_address' => $data['entered_address'] == null ? '' : $data['entered_address'],
                'address' => Auth::user()->address,
                'phone' => $data['phone'],
                'note' => $data['note'] == null ? '' : $data['note'],
                'delivery_date' => null,
                'status' => 1,
            ]);

            foreach ($productsToOrder as $item) {
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'discount' => $item['discount'],
                ]);
            }

            $request->session()->flash('order_success', 'Đặt hàng thành công, vui lòng chờ xác nhận!');

            return redirect('/profile?section=orders')->withCookie(cookie('cart', json_encode([])));
        } else {
            return redirect()->back();
        }

        

        // return response()->json($data);
    }

    public function fallback() {
        return view('pages.page404', [
            'title' => 'NOS Fruits - Không có trang này trên shop'
        ]);
    }
}
