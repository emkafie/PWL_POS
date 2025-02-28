<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = [];
        $detailId = 1;

        for ($penjualanId = 1; $penjualanId <= 10; $penjualanId++) {
            for ($barangId = 1; $barangId <= 3; $barangId++) {
                $details[] = [
                    'detail_id' => $detailId++,
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barangId,
                    'harga' => 10000 * $barangId,
                    'jumlah' => $barangId,
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($details);
    }
}
