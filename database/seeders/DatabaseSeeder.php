<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Zahrah',
            'username' => 'zahrah',
            'role' => 'user',
            'password' => Hash::make('zahrah'),
        ]);
        User::create([
            'name' => 'Kantin',
            'username' => 'kantin',
            'role' => 'kantin',
            'password' => Hash::make('kantin'),
        ]);
        User::create([
            'name' => 'Bank',
            'username' => 'bank',
            'role' => 'bank',
            'password' => Hash::make('bank'),
        ]);
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        Product::create([
            'name' => 'Piscok',
            'price' => 3000,
            'stock' => 50,
            'photo' => 'images/piscok.png',
            'category' => 'makanan',
            'description' => 'Pisang coklat',
        ]);
        Product::create([
            'name' => 'Bakso',
            'price' => 10000,
            'stock' => 50,
            'photo' => 'images/bakso.png',
            'category' => 'makanan',
            'description' => 'Bakso urat',
        ]);
        Product::create([
            'name' => 'Es Teh',
            'price' => 3000,
            'stock' => 50,
            'photo' => 'images/lemon-tea.png',
            'category' => 'minuman',
            'description' => 'Es teh manis',
        ]);
        Transaction::create([
            'user_id' => 1,
            'product_id' => 1,
            'price' => 3000,
            'quantity' => 1,
            'status' => 'di keranjang',
            'order_id' => 'INV_12345',
        ]);
        Wallet::create([
            'user_id' => 1,
            'credit' => 20000,
            'status' => 'selesai',
            'description' => 'Pembukaan rekening',
        ]);
    }
}
