<?php

namespace Database\Factories;

use App\Models\Vcenter;
use App\Models\Vm;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VmFactory extends Factory
{
    protected $model = Vm::class;

    public function definition(): array
    {
        return [
            'name'       => $this->faker->name,
            'task_id'    => "Task-task-{$this->faker->randomNumber()}",
            'status'     => $this->faker->randomElement([
                Vm::STATUS_IDLE, Vm::STATUS_WAITING, Vm::STATUS_CLONING,
                Vm::STATUS_MIGRATING, Vm::STATUS_COMPLETED, Vm::STATUS_FAILED
            ]),
            'percentage' => $this->faker->numberBetween(0, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'src_vcenter_id' => function () {
                return Vcenter::factory()->create()->id;
            },
            'dst_vcenter_id' => function () {
                return Vcenter::factory()->create()->id;
            },
        ];
    }
}
