<?php

namespace App\Jobs;

use App\Actions\MigrateVMAction;
use App\Models\Vm;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MigrateVMJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Vm $vm;

    public function __construct(Vm $vm)
    {
        $this->vm = $vm;
    }

    public function handle(): void
    {
        (new MigrateVMAction($this->vm))->execute();
    }
}
