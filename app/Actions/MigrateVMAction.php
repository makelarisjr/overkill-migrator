<?php

namespace App\Actions;

use App\Models\Vm;
use App\Traits\ExecutesPowershell;

class MigrateVMAction
{
    use ExecutesPowershell;

    const SUCCESS_STATUS = Vm::STATUS_MIGRATING;

    private Vm $vm;

    public function __construct(Vm $vm)
    {
        $this->vm = $vm->load([
            'srcVcenter', 'dstVcenter'
        ]);

        $this->vm->update([
            'status' => Vm::STATUS_WAITING
        ]);
    }

    public function execute(): void
    {
        $this->executePowershell('MigrateAsync');
    }
}
