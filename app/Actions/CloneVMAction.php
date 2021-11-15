<?php

namespace App\Actions;

use App\Models\Vm;
use App\Traits\ExecutesPowershell;

class CloneVMAction
{
    use ExecutesPowershell;

    const SUCCESS_STATUS = Vm::STATUS_CLONING;

    private Vm $vm;

    public function __construct(Vm $vm)
    {
        $this->vm = $vm->load('srcVcenter');
    }

    public function execute(): void
    {
        $this->executePowershell('CloneAsync');
    }
}
