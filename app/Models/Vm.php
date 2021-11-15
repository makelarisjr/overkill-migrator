<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vm extends Model
{
    use HasFactory;

    const STATUS_IDLE      = 'idle';
    const STATUS_WAITING   = 'waiting';
    const STATUS_CLONING   = 'cloning';
    const STATUS_MIGRATING = 'migrating';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED    = 'failed';

    protected $guarded = [];

    public function srcVcenter(): BelongsTo
    {
        return $this->belongsTo(Vcenter::class, 'src_vcenter_id');
    }

    public function dstVcenter(): BelongsTo
    {
        return $this->belongsTo(Vcenter::class, 'dst_vcenter_id');
    }
}
