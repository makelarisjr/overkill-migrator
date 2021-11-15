<?php

namespace App\Observers;

use App\Actions\SendDiscordWebhookAction;
use App\Models\Vm;

class VmObserver
{
    public function updating(Vm $vm)
    {
        if ($vm->isDirty('status'))
        {
            if (!in_array($vm->status, [Vm::STATUS_IDLE, Vm::STATUS_WAITING]))
            {
                (new SendDiscordWebhookAction($vm))->execute();
            }
        }
    }
}
