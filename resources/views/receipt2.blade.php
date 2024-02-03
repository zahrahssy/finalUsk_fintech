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
                    <th scope="col">Kredit</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Tanggal/Waktu</th>
                </tr>
            </thead>
            @foreach($wallets as $key => $wallet)
            <tbody>
                <tr>
                    <th scope="row">{{ $key +1 }}</th>
                    <td>{{ $wallet->user->name }}</td>
                    <td>{{ $wallet->credit }}</td>
                    <td>{{ $wallet->debit }}</td>
                    <td>{{ $wallet->description }}</td>
                    <td>{{ $wallet->created_at }}</td>
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