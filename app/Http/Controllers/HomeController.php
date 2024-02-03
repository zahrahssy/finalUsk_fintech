<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'user') {
            $products = Product::all();
            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status', 'selesai')->get();
            $credit = 0;
            $debit = 0;

            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }
            $saldo = $credit - $debit;

            $carts = Transaction::where('status', 'di keranjang')->get();
            $total_biaya = 0;

            foreach ($carts as $cart) {
                $total_price = $cart->quantity * $cart->price;
                $total_biaya += $total_price;
            };

            $mutasi = Wallet::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            $transactions = Transaction::where('status', 'dibayar')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_id');

            return view('home', compact('products', 'saldo', 'mutasi', 'transactions', 'carts', 'total_biaya'));
        }

        if (Auth::user()->role == 'bank') {
            $wallets = Wallet::where('status', 'selesai')->get();
            $users = User::where('role', 'user')->get();

            $credit = 0;
            $debit = 0;

            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }
            $saldo = $credit - $debit;
            $nasabah = User::where('role', 'user')->get()->count();
            $request_payment = Wallet::where('status', 'proses')->orderBy('created_at', 'DESC')->get();
            $transactions = Transaction::all()->groupBy('order-id')->count();
            $mutasi = Wallet::where('status', 'selesai')->orderBy('created_at', 'DESC')->get();

            return view('home', compact('saldo', 'wallets', 'nasabah', 'request_payment', 'transactions', 'mutasi', 'users'));
        }

        if (Auth::user()->role == 'kantin') {
            $products = Product::all();
            $transactions = Transaction::all();
            $wallets = Wallet::where('description', 'Pembelian produk')->get();

            $credit = 0;

            foreach ($wallets as $wallet) {
                $credit += $wallet->debit;
            }
            $saldo = $credit;

            return view('home', compact('saldo', 'products', 'transactions'));
        }

        if (Auth::user()->role == 'admin') {
            $users = User::all();
            $mutasi = Wallet::where('status', 'selesai')->orderBy('created_at', 'DESC')->get();
            $transactions = Transaction::where('status', 'dibayar')->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_id');

            return view('home', compact('mutasi', 'transactions', 'users'));
        }
    }
}
