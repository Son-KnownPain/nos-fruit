<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class UserController extends Controller
{
    public function profile(Request $req) {
        $queries = $req->query();
        $section = $queries['section'] ?? '';

        if ($section == 'orders') {
            $req->session()->now('orders', 'DEFAULT');
        }

        $title = $section == 'orders' ? 'Đơn hàng của tôi' : 'Trang cá nhân';
        $active = $section == 'orders' ? 'orders' : 'profile';

        // Lấy các đơn hàng của khách hàng

        $orders = [];

        $index = 0;
        $orderRecords = Order::where('user_id', '=', Auth::user()->id)->get();
        foreach ($orderRecords as $orderRecord) {

            $orderDetailRecords = OrderDetail::where('order_id', '=', $orderRecord->id)->get();
            $totalPrice = 0;

            foreach ($orderDetailRecords as $item) {
                $totalPrice += ($item->unit_price - ($item->unit_price * $item->discount)) * $item->quantity;
            }

            $orders[$index] = [
                'orderRecord' => $orderRecord,
                'totalPrice' => $totalPrice,
            ];

            $index++;
        }

        return view('pages.profile', [
            'title' => 'NOS Fruits - '.$title,
            'active' => $active,
            'user' => Auth::user(),
            'orders' => $orders
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function emailVerify(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return view('pages.verify', [
            'title' => 'NOS Fruits - Xác thực email'
        ]);
    }

    public function emailConfirm(EmailVerificationRequest $request) {
        $request->fulfill();

        $request->session()->flash('verify_success', 'Xác thực tài khoản thành công');

        return redirect('/profile');
    }

    public function resendEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }

    // Action đăng nhập
    public function loginCheck(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'level' => 1])) {
            return response()->json(['isLogin' => true]);;
        } else {
            $request->session()->flash('user-wrong', 'Tài khoản hoặc mật khẩu không chính xác');
            return response()->json(['isLogin' => false]);
        }
    }

    public function updateAddress(Request $request) {
        $province = $request->input('province');
        $district = $request->input('district');
        $ward = $request->input('ward');

        $newAddress = $ward.', '.$district.', '.$province;

        $user = User::findOrFail(Auth::user()->id);

        $user->update(['address' => $newAddress]);

        return redirect()->back();
    }

    public function store(Request $request) {
        // Dữ liệu nhận từ người dùng
        $data = $request->all();

        $request->validate([
            'name' => 'required',
            'phone' => 'required|digits:10',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => 'Chưa cung cấp địa chỉ',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'level' => 1
        ]);

        Auth::login($user);

        return response()->json(['isCreate' => true]);

    }

    // Admin
    public function users(Request $request) {
        $users;
        if ($request->query()) {
            $keyword = $request->query()['search'];
            $level = $request->query()['level'];
            if ($level == 0) {
                $users = User::where('name', 'LIKE', "%$keyword%")->get();
            } else {
                $users = User::where('name', 'LIKE', "%$keyword%")->where('level', '=', $level)->get();
            }
        } else {
            $users = User::all();
        }

        return view('admin.users.index', [
            'title' => 'Quản lí người dùng',
            'users' => $users
        ]);
    }

    public function edit(Request $request, $id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', [
            'title' => 'Chỉnh sửa thông tin người dùng',
            'user' => $user
        ]);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $data = $request->all();

        $user->update($data);

        $request->session()->flash('update', 'Chỉnh sửa thành công');
        return response()->json(['isUpdate' => true]);;
    }

    public function userOrderDetail(Request $request, $id) {
        $orders = [];

        $index = 0;
        $orderRecords = Order::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->get();
        foreach ($orderRecords as $orderRecord) {

            $orderDetailRecords = OrderDetail::where('order_id', '=', $orderRecord->id)->get();
            foreach ($orderDetailRecords as $orderDetail) {
                $orderDetail['thumbnail'] = Product::findOrFail($orderDetail['product_id'])->thumbnail;
                $orderDetail['product_name'] = Product::findOrFail($orderDetail['product_id'])->name;
            }
            $totalPrice = 0;

            foreach ($orderDetailRecords as $item) {
                $totalPrice += ($item->unit_price - ($item->unit_price * $item->discount)) * $item->quantity;
            }

            $orders[$index] = [
                'orderRecord' => $orderRecord,
                'totalPrice' => $totalPrice,
                'orderDetailRecords' => $orderDetailRecords,
                'user' => Auth::user()
            ];

            $index++;
        }

        return response()->json([
            'order' => empty($orders) ? null : $orders[0],
        ]);
    }
}
