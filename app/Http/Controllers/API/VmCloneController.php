<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\CloneVMJob;
use App\Models\Vm;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VmCloneController extends Controller
{
    public function __invoke(Vm $vm): JsonResource
    {
        if ($vm->status !== Vm::STATUS_IDLE)
        {
            throw new BadRequestHttpException();
        }

        $job_id = $this->dispatch(new CloneVMJob($vm));

        $vm->update([
            'status' => Vm::STATUS_WAITING
        ]);

        return new JsonResource(compact('job_id'));
    }
}
