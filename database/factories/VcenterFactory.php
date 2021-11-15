<?php

namespace Database\Factories;

use App\Models\Vcenter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VcenterFactory extends Factory
{
    protected $model = Vcenter::class;

    public function definition(): array
    {
        return [
            'host'       => "{$this->faker->word}.fakevc.makjr.local",
            'esxi'       => "esxi-{$this->faker->word}.fakevc.makjr.local",
            'user'       => 'administrator',
            'password'   => $this->faker->password,
            'datastore'  => "datastore{$this->faker->randomNumber()}",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
