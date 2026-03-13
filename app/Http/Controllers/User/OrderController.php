<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function payment($kw)
    {
         $order = Order::with(['package.game'])->where('no_kw', $kw)->first();
        return view('pages.user.transaksi.finish', compact('order'));
    }

    public function search($kw)
    {
        $order = Order::with(['package.game'])->where('no_kw', $kw)->first();

        return view('pages.user.transaksi.finish', compact('order'));
    }
}
