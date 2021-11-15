<?php

namespace Database\Seeders;

use App\Models\Vm;
use Illuminate\Database\Seeder;

class VmSeeder extends Seeder
{
    public function run()
    {
        Vm::factory()
            ->createMany([
                [
                    'name'           => 'pfSense Test',
                    'src_vcenter_id' => 1,
                    'dst_vcenter_id' => 2,
                    'status'         => Vm::STATUS_IDLE,
                    'percentage'     => 0
                ],
                [
                    'name'           => 'Win10Dev',
                    'src_vcenter_id' => 1,
                    'dst_vcenter_id' => 2,
                    'status'         => Vm::STATUS_IDLE,
                    'percentage'     => 0
                ],
                [
                    'name'           => 'gw-gr-her1.makjr.eu',
                    'src_vcenter_id' => 1,
                    'dst_vcenter_id' => 2,
                    'status'         => Vm::STATUS_IDLE,
                    'percentage'     => 0
                ]
            ]);
    }
}
