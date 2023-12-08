<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function orders(Request $request) {

        $orders = [];

        $index = 0;
        $orderRecords = Order::all();
        foreach ($orderRecords as $orderRecord) {

            $orderDetailRecords = OrderDetail::where('order_id', '=', $orderRecord->id)->get();
            $totalPrice = 0;

            foreach ($orderDetailRecords as $item) {
                $totalPrice += ($item->unit_price - ($item->unit_price * $item->discount)) * $item->quantity;
            }

            $orders[$index] = [
                'orderRecord' => $orderRecord,
                'totalPrice' => $totalPrice,
                'orderDetailRecords' => $orderDetailRecords,
                'user' => User::findOrFail($orderRecord->user_id)
            ];

            $index++;
        }

        return view('admin.orders.index', [
            'title' => 'Quản lí đơn hàng',
            'orders' => $orders,
        ]);
    }

    public function confirmOrder(Request $request, $id) {
        $order = Order::findOrFail($id);

        $order->status = 2;
        $order->save();

        $request->session()->flash('sm', "Xác nhận đơn hàng thành công");

        return redirect()->back();
    }

    public function deliveryOrder(Request $request, $id) {
        $order = Order::findOrFail($id);

        $order->status = 3;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->delivery_date = date('Y-m-d H:m:s');
        $order->save();

        $request->session()->flash('sm', "Đơn hàng đã giao thành công");

        return redirect()->back();
    }
}
