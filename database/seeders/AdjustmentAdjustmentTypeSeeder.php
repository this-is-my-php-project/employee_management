<?php

namespace Database\Seeders;

use App\Modules\Adjustment\Adjustment;
use App\Modules\Adjustment\Constants\AdjustmentConstants;
use App\Modules\AdjustmentType\AdjustmentType;
use App\Modules\AdjustmentType\Constants\AdjustmentTypeConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdjustmentAdjustmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adjustmentTypes = [
            [
                'id' => 1,
                'name' => AdjustmentTypeConstants::CORRECTION,
                'status' => true,
                'is_global' => true,
                'workspace_id' => null,
            ],
            [
                'id' => 2,
                'name' => AdjustmentTypeConstants::LEAVE,
                'status' => true,
                'is_global' => true,
                'workspace_id' => null,
            ],
            [
                'id' => 3,
                'name' => AdjustmentTypeConstants::REMOTE,
                'status' => true,
                'is_global' => true,
                'workspace_id' => null,
            ],
            [
                'id' => 4,
                'name' => AdjustmentTypeConstants::OTHER,
                'status' => true,
                'is_global' => true,
                'workspace_id' => null,
            ],
        ];
        AdjustmentType::insert($adjustmentTypes);

        $adjustments = [
            [
                'id' => 1,
                'name' => AdjustmentConstants::CORRECTION,
                'status' => true,
                'adjustment_type_id' => 1,
                'workspace_id' => null,
                'is_global' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => AdjustmentConstants::ANNUAL_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 3,
                'name' => AdjustmentConstants::SICK_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 4,
                'name' => AdjustmentConstants::MATERNITY_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 5,
                'name' => AdjustmentConstants::PATERNITY_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 6,
                'name' => AdjustmentConstants::UNPAID_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 7,
                'name' => AdjustmentConstants::COMPENSATORY_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 8,
                'name' => AdjustmentConstants::OTHER_LEAVE,
                'status' => true,
                'adjustment_type_id' => 2,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 9,
                'name' => AdjustmentConstants::REMOTE,
                'status' => true,
                'adjustment_type_id' => 3,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 10,
                'name' => AdjustmentConstants::LATE,
                'status' => true,
                'adjustment_type_id' => 4,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 11,
                'name' => AdjustmentConstants::ABSENT,
                'status' => true,
                'adjustment_type_id' => 4,
                'workspace_id' => null,
                'is_global' => true,
            ],
            [
                'id' => 12,
                'name' => AdjustmentConstants::OTHER,
                'status' => true,
                'adjustment_type_id' => 4,
                'workspace_id' => null,
                'is_global' => true,
            ],
        ];
        Adjustment::insert($adjustments);
    }
}
