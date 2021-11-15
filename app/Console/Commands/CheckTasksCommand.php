<?php

namespace App\Console\Commands;

use App\Actions\GetTaskAction;
use App\Jobs\MigrateVMJob;
use App\Models\Vm;
use Illuminate\Console\Command;

class CheckTasksCommand extends Command
{
    protected $signature = 'vm:tasks';

    protected $description = 'Checks all vm tasks';

    public function handle()
    {
        Vm::all()
            ->whereIn('status', [Vm::STATUS_CLONING, Vm::STATUS_MIGRATING])
            ->each(function (Vm $vm) {
                $vm = (new GetTaskAction($vm))->execute();

                if ($vm->percentage >= 100)
                {
                    if ($vm->status === Vm::STATUS_CLONING)
                    {
                        MigrateVMJob::dispatch($vm);
                    }
                    else if ($vm->status === Vm::STATUS_MIGRATING)
                    {
                        $vm->update([
                            'status' => Vm::STATUS_COMPLETED
                        ]);
                    }
                }
            });
    }
}
