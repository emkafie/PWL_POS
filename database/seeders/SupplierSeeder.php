<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_id'   => 1,
                'supplier_code' => 'SUP001',
                'supplier_nama' => 'PT Sumber Makmur',
                'email'         => 'sumbermakmur@gmail.com',
                'no_telp'       => '081234567890',
                'address'       => 'Jl. Merdeka No. 1, Jakarta',
            ],
            [
                'supplier_id'   => 2,
                'supplier_code' => 'SUP002',
                'supplier_nama' => 'CV Berkah Jaya',
                'email'         => 'berkahjaya@yahoo.com',
                'no_telp'       => '082345678901',
                'address'       => 'Jl. Sudirman No. 15, Bandung',
            ],
            [
                'supplier_id'   => 3,
                'supplier_code' => 'SUP003',
                'supplier_nama' => 'PT Sentosa Abadi',
                'email'         => 'sentosa.abadi@gmail.com',
                'no_telp'       => '081345678912',
                'address'       => 'Jl. Ahmad Yani No. 22, Surabaya',
            ],
            [
                'supplier_id'   => 4,
                'supplier_code' => 'SUP004',
                'supplier_nama' => 'CV Maju Terus',
                'email'         => 'majuterus@outlook.com',
                'no_telp'       => '083456789123',
                'address'       => 'Jl. Diponegoro No. 5, Semarang',
            ],
            [
                'supplier_id'   => 5,
                'supplier_code' => 'SUP005',
                'supplier_nama' => 'PT Amanah Sejahtera',
                'email'         => 'amanah.sejahtera@gmail.com',
                'no_telp'       => '084567891234',
                'address'       => 'Jl. Gajah Mada No. 8, Medan',
            ],
        ]);
    }
}
