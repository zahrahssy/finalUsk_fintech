@extends('layouts.app')

@php
function rupiah($angka){
$hasil_rupiah = "Rp" . number_format($angka, 0, ',', '.');
return $hasil_rupiah;
}
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Order_id</th>
                    <th scope="col">Tanggal/Waktu</th>
                </tr>
            </thead>
            @foreach($transactions as $key => $transaction)
            <tbody>
                <tr>
                    <th scope="row">{{ $key +1 }}</th>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->product->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->price }}</td>
                    <td>{{ $transaction->order_id }}</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection

<script>
    print()
</script>