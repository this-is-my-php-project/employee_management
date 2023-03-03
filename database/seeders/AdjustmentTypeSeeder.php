<?php

namespace Database\Seeders;

use App\Modules\AdjustmentType\AdjustmentType;
use App\Modules\AdjustmentType\Constants\AdjustmentTypeConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdjustmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => AdjustmentTypeConstant::LATE['name'],
                'key' => AdjustmentTypeConstant::LATE['key'],
            ],
        ];

        AdjustmentType::insert($data);
    }
}
