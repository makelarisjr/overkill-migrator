<?php

namespace App\Http\Resources;

use App\Models\Vm;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class VmResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Vm $vm */
        $vm = $this->resource;

        return [
            'id'         => $vm->id,
            'name'       => $vm->name,
            'task_id'    => $vm->task_id,
            'status'     => $vm->status,
            'percentage' => $vm->percentage,
            'src_vc'     => $vm->srcVcenter->only('host', 'esxi'),
            'dst_vc'     => $vm->dstVcenter->only('host', 'esxi')
        ];
    }
}
