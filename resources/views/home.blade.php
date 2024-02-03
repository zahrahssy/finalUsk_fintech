@extends('layouts.app')

@php
function rupiah($angka){
$hasil_rupiah = "Rp" . number_format($angka, 0, ',', '.');
return $hasil_rupiah;
}
@endphp

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<div class="container">
    @if(Auth::user()->role == 'user')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header fw-bold"> {{ __('Saldo') }}</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-7 justify-content-start text-green fw-bold" style="font-size: x-large;">
                            {{ rupiah($saldo) }}
                        </div>
                        <div class="col d-flex justify-content-end">
                            <div class="col">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#topUp">Top Up</button>

                                <!-- Modal -->
                                <form action="{{ route('topUp') }}" method="POST">
                                    @csrf
                                    <div class="modal fade" id="topUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="credit" min="10000" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Top Up</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#withDraw">Tarik Tunai</button>

                                <!-- Modal -->
                                <form action="{{ route('withDrawal') }}" method="POST">
                                    @csrf
                                    <div class="modal fade" id="withDraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="debit" max="{{ $saldo }}" value="10000">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Tarik Tunai</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header fw-bold">{{ __('Katalog Produk') }}</div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4 py-3">
                        @foreach ($products as $key => $product)
                        <div class="col">
                            <form action="{{ route('addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">

                                <div class="card shadow">
                                    <div class="card-header" style="height: 160px;">
                                        <img src="{{ $product->photo }}" width="150px">
                                    </div>
                                    <div class="card-body">
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <div class="fw-bold" style="color: #183D3D;">{{ rupiah($product->price) }}</div>
                                        <div style="color: #183D3D;">{{ $product->description }}</div>
                                        <div style="font-size: small;">Stock: {{ $product->stock }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-5 d-flex justify-content-start">
                                                <input type="number" name="quantity" class="form-control" min="1" value="1">
                                            </div>
                                            <div class="col-5 d-flex justify-content-end">
                                                @if($product->stock == 0)
                                                <button type="submit" class="btn btn-primary" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                                    </svg>
                                                </button>
                                                @else
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z" />
                                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                                    </svg>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header fw-bold">{{ __('Keranjang') }}</div>
                <div class="card-body">
                    @foreach($carts as $cart)
                    <ul class="d-flex justify-content-between mb-3">
                        <li>
                            {{ $cart->product->name }} &nbsp; {{ $cart->quantity }}x &nbsp; {{ $cart->price }}
                        </li>
                        <form action="{{ route('deleteCart', ['id'=>$cart->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </form>
                    </ul>
                    @endforeach
                </div>
                <div class="card-footer fw-bold">
                    Total biaya : {{ rupiah($total_biaya) }}
                    <form action="{{ route('payNow') }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2 mt-2">
                            @if($total_biaya == 0)
                            <button class="btn btn-primary" type="submit" disabled>Bayar Sekarang</button>
                            @elseif($saldo < $total_biaya) <span class="text-red" style="font-size: 12px;">*Saldo anda kurang</span>
                                <button class="btn btn-primary" type="submit" disabled>Bayar Sekarang</button>
                                @else
                                <button class="btn btn-primary" type="submit">Bayar Sekarang</button>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header fw-bold">{{ __('Mutasi') }}</div>
                <div class="card-body">
                    @foreach($mutasi as $data)
                    <ul>
                        <li>
                            {{ $data->credit ? $data->credit : 'Debit' }} | {{ $data->debit ? $data->debit : 'Kredit' }} | {{ $data->description }}
                            @if($data->status == 'proses')
                            <span class="badge bg-warning text-black">PROSES</span>
                            @endif
                        </li>
                    </ul>
                    @endforeach
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header fw-bold">{{ __('Laporan Transaksi') }}</div>
                <div class="card-body">
                    @foreach($transactions as $transaction)
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="row">
                                <div class="col fw-bold" style="font-size: 16px;">
                                    {{ $transaction[0]->order_id }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size: small;">
                                    {{ $transaction[0]->created_at }}
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{ route('download', $transaction[0]->order_id) }}" class="btn btn-primary" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                    <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if(Auth::user()->role == 'bank')
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header fw-bold">Saldo</div>
                        <div class="card-body text-green fw-bold" style="font-size: x-large;">
                            {{ rupiah($saldo) }}
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#topUp1">Top Up</button>

                                    <!-- Modal -->
                                    <form action="{{ route('topUp1') }}" method="POST">
                                        @csrf
                                        <div class="modal fade" id="topUp1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <select name="id" class="form-control">
                                                                <option value="">--Pilih Pengguna--</option>
                                                                @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input type="number" class="form-control" name="credit" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Top Up</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#withDraw1">Tarik Tunai</button>

                                    <!-- Modal -->
                                    <form action="{{ route('withDrawal1') }}" method="POST">
                                        @csrf
                                        <div class="modal fade" id="withDraw1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <select name="id" class="form-control">
                                                                <option value="">--Pilih Pengguna--</option>
                                                                @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input type="number" class="form-control" name="debit" min="10000" max="{{ $saldo }}" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Tarik Tunai</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header fw-bold">Laporan Transaksi</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col fw-bold" style="font-size: 16px;">
                                            Download Laporan Transaksi
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end align-items-center">
                                    <a href="{{ route('download2') }}" class="btn btn-primary" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                            <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header fw-bold">Permintaan Top Up & Tarik Tunai</div>
                        <div class="card-body">
                            @foreach($request_payment as $request)
                            <form action="{{ route('accRequest') }}" method="POST">
                                @csrf
                                <input type="hidden" name="wallet_id" value="{{ $request->id }}">
                                <div class="card bg-white shadow border-0 mb-3">
                                    <div class="card-header fw-bold">
                                        {{ $request->user->name }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if($request->credit)
                                            <div class="col my-auto fw-bold">
                                                <span class="text-green">Top Up : {{ rupiah($request->credit) }}</span>
                                            </div>
                                            @elseif($request->debit)
                                            <div class="col my-auto fw-bold">
                                                <span class="text-red">Tarik Tunai : {{ rupiah($request->debit) }}</span>
                                            </div>
                                            @endif
                                            <div class="text-secondary">
                                                <p>{{ $request->created_at }}</p>
                                            </div>
                                            <div class="col text-end">
                                                <button type="submit" class="btn btn-primary">Accept</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header fw-bold">Daftar Mutasi</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nominal</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Tanggal/Waktu</th>
                                </tr>
                            </thead>
                            @foreach($wallets as $key => $wallet)
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $wallet->user->name }}</td>
                                    @if($wallet->credit)
                                    <td class="text-green">{{ rupiah($wallet->credit) }}</td>
                                    @else
                                    <td class="text-red">{{ rupiah($wallet->debit) }}</td>
                                    @endif
                                    <td>{{ $wallet->description }}</td>
                                    <td>{{ $wallet->created_at }}</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Auth::user()->role == 'kantin')
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-header fw-bold">Saldo</div>
                    <div class="card-body fw-bold text-green" style="font-size: x-large;">{{ rupiah($saldo) }}</div>
                </div>
                <div class="card">
                    <div class="card-header fw-bold">Laporan Transaksi</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col fw-bold" style="font-size: 16px;">
                                        Download Laporan Transaksi
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center">
                                <a href="{{ route('download1') }}" class="btn btn-primary" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                        <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header fw-bold">
                        <div class="col-6 d-flex justify-content-start align-items-center">Katalog Produk</div>
                        <div class="col d-flex justify-content-end">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">Tambah Produk</button>

                            <!-- Modal -->
                            <form action="{{ route('product.store') }}" method="POST">
                                @csrf
                                <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label>Nama</label>
                                                                <input type="text" name="name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label>Kategori</label>
                                                                <select name="category" class="form-control">
                                                                    <option value="">--Pilih Kategori--</option>
                                                                    <option value="makanan">Makanan</option>
                                                                    <option value="minuman">Minuman</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label>Stok</label>
                                                                <input type="number" name="stock" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label>Harga</label>
                                                                <input type="number" name="price" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Foto</label>
                                                        <input type="text" name="photo" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach($products as $key => $product)
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $key +1 }}</th>
                                    <td>
                                        <img src="{{ $product->photo }}" width="50">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-warning text-black" data-bs-toggle="modal" data-bs-target="#editProduct-{{ $product->id }}">Edit</button>

                                                <!-- Modal -->
                                                <form action="{{ route('product.update', ['id'=>$product->id]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal fade" id="editProduct-{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Produk</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row justify-content-center">
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label>Nama</label>
                                                                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label>Kategori</label>
                                                                                    <select name="category" class="form-control">
                                                                                        <option value="{{ $product->category }}">{{ $product->category }}</option>
                                                                                        <option value="makanan">Makanan</option>
                                                                                        <option value="minuman">Minuman</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label>Stok</label>
                                                                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label>Harga</label>
                                                                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Foto</label>
                                                                            <input type="text" name="photo" class="form-control" value="{{ $product->photo }}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Description</label>
                                                                            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <form action="{{ route('product.destroy', ['id'=>$product->id]) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus {{ $product->name }}?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Auth::user()->role == 'admin')
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card">
                    <div class="card-header fw-bold">Laporan Transaksi</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col fw-bold" style="font-size: 16px;">
                                        Download Laporan Transaksi
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center">
                                <a href="{{ route('download2') }}" class="btn btn-primary" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                        <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="card">
                    <div class="card-header fw-bold">
                        <div class="col d-flex justify-content-start">
                            Daftar Pengguna
                        </div>
                        <div class="col d-flex justify-content-end">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">Tambah Pengguna</button>

                            <!-- Modal -->
                            <form action="{{ route('store') }}" method="POST">
                                @csrf
                                <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pengguna</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <label>Nama</label>
                                                            <input type="text" name="name" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <label>Username</label>
                                                            <input type="text" name="username" class="form-control" required>
                                                        </div>
                                                        <div class="col">
                                                            <label>Role</label>
                                                            <select name="role" class="form-control" required>
                                                                <option value="">-- Pilih Role --</option>
                                                                <option value="user">User</option>
                                                                <option value="bank">Bank</option>
                                                                <option value="kantin">Kantin</option>
                                                                <option value="admin">Admin</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col mb-3">
                                                            <label>Password</label>
                                                            <input type="text" name="password" class="form-control" required>
                                                        </div>
                                                        <div class="col mb-3">
                                                            <label>Confirm Password</label>
                                                            <input type="text" name="confirm-password" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            @foreach($users as $key => $user)
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $key +1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-warning text-black" data-bs-toggle="modal" data-bs-target="#editUser-{{ $user->id }}">Edit</button>

                                                <!-- Modal -->
                                                <form action="{{ route('update', ['id' => $user->id ]) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal fade" id="editUser-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pengguna</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="col mb-3">
                                                                                <label>Nama</label>
                                                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col mb-3">
                                                                                <label>Username</label>
                                                                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                                                            </div>
                                                                            <div class="col">
                                                                                <label>Role</label>
                                                                                <select name="role" class="form-control" required>
                                                                                    <option value="{{ $user->role}}">{{ $user->role }}</option>
                                                                                    <option value="user">User</option>
                                                                                    <option value="bank">Bank</option>
                                                                                    <option value="kantin">Kantin</option>
                                                                                    <option value="admin">Admin</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col mb-3">
                                                                                <label>Password</label>
                                                                                <input type="text" name="password" class="form-control" placeholder="(not changed)" disabled>
                                                                            </div>
                                                                            <div class="col mb-3">
                                                                                <label>Confirm Password</label>
                                                                                <input type="text" name="confirm-password" class="form-control" placeholder="(not changed)" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <form action="{{ route('destroy', ['id'=>$user->id]) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus {{ $user->name }}?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endsection