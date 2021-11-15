<?php

namespace App\Actions;

use App\Models\Vm;
use App\Traits\ExecutesPowershell;

class GetTaskAction
{
    use ExecutesPowershell;

    private Vm $vm;

    public function __construct(Vm $vm)
    {
        $this->vm = $vm->load('srcVcenter');
    }

    public function execute(): Vm
    {
        return $this->executePowershell('GetTask');
    }
}
