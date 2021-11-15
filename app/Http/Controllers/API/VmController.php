<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VmResource;
use App\Models\Vm;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VmController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return VmResource::collection(Vm::all());
    }
}
