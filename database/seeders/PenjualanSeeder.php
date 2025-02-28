<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'Andi',
                'penjualan_kode' => 'PNJ001',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'Budi',
                'penjualan_kode' => 'PNJ002',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Citra',
                'penjualan_kode' => 'PNJ003',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Dodi',
                'penjualan_kode' => 'PNJ004',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Eka',
                'penjualan_kode' => 'PNJ005',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Farah',
                'penjualan_kode' => 'PNJ006',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Gilang',
                'penjualan_kode' => 'PNJ007',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Hadi',
                'penjualan_kode' => 'PNJ008',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Indah',
                'penjualan_kode' => 'PNJ009',
                'penjualan_tanggal' => Carbon::now(),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Joko',
                'penjualan_kode' => 'PNJ010',
                'penjualan_tanggal' => Carbon::now(),
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
