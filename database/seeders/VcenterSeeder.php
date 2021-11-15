<?php

namespace Database\Seeders;

use App\Models\Vcenter;
use Illuminate\Database\Seeder;

class VcenterSeeder extends Seeder
{
    public function run()
    {
        Vcenter::factory()
            ->createMany([
                [
                    'host'      => '10.69.3.10',
                    'esxi'      => '10.69.3.9',
                    'user'      => 'administrator@vcnet.makjr.eu',
                    'password'  => 'TheB3stT3st1ngPassw0rd!'
                ],
                [
                    'host'      => '10.69.3.12',
                    'esxi'      => '10.69.3.11',
                    'user'      => 'administrator@vcnet.makjr.eu',
                    'password'  => 'TheB3stT3st1ngPassw0rd!'
                ]
            ]);
    }
}
