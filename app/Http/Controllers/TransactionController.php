<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payNow()
    {
        $status = 'dibayar';
        $order_id = 'INV_ ' . (Auth::user()->id) . date('YmdHis');

        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'di keranjang')->get();

        $total_debit = 0;
        foreach ($carts as $cart) {
            $total_price = $cart->quantity * $cart->price;
            $total_debit += $total_price;
        }
        Wallet::create([
            'user_id' => Auth::user()->id,
            'debit' => $total_debit,
            'status' => 'selesai',
            'description' => 'Pembelian produk',
        ]);

        foreach ($carts as $cart) {
            if ($cart->product->stock > 0) {
                Transaction::find($cart->id)->update([
                    'status' => $status,
                    'order_id' => $order_id,
                ]);

                Product::find($cart->product->id)->update([
                    'stock' => $cart->product->stock - $cart->quantity,
                ]);
            } else {
                $total_debit = $total_debit - ($cart->quantity * $cart->product_price);
            }
        }
        return redirect()->back()->with('status', 'Pembayaran sukses');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'di keranjang';
        $price = $request->price;
        $quantity = $request->quantity;

        $stock = Product::find($product_id)->stock;
        if ($quantity > $stock) {
            return redirect()->back()->with('status', 'Jumlah pesanan melebihi stok');
        }

        $product = Product::find($request->product_id);

        $existingCartItem = Transaction::where('product_id', $product_id)->first();

        if ($existingCartItem) {
            $totalQuantity = $existingCartItem->quantity + $quantity;

            if ($totalQuantity > $product->stock) {
                return redirect()->back()->with('status', 'Jumlah pesanan melebihi stok');
            }

            // Update quantity jika produk sudah ada di keranjang
            $existingCartItem->update(['quantity' => $totalQuantity]);
        }

        $transactions = Transaction::where('user_id', $user_id)->where('product_id', $product_id)->where('status', 'di keranjang')->first();
        if ($transactions) {
            $transactions->quantity += $quantity;
            $transactions->save();
        } else {
            Transaction::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'status' => $status,
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }
        return redirect()->back()->with('status', 'Berhasil menambahkan ke keranjang');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCart($id)
    {
        Transaction::find($id)->delete();

        return redirect()->back()->with('status', 'Berhasil menghapus dari keranjang');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function download($order_id)
    {
        $transactions = Transaction::where('order_id', $order_id)->where('user_id', Auth::user()->id)->get();
        $total_biaya = 0;

        foreach ($transactions as $transaction) {
            $total_price = $transaction->price * $transaction->quantity;
            $total_biaya += $total_price;
        }
        return view('receipt', compact('transactions', 'total_biaya'));
    }

    public function download1(Transaction $transactions)
    {
        $transactions = Transaction::all();
        $total_biaya = 0;

        foreach ($transactions as $transaction) {
            $total_price = $transaction->price * $transaction->quantity;
            $total_biaya += $total_price;
        }
        return view('receipt1', compact('transactions', 'total_biaya'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
