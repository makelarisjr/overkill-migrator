<?php

namespace App\Actions;

use App\Models\Vm;
use Illuminate\Support\Facades\Http;

class SendDiscordWebhookAction
{
    private Vm $vm;

    public function __construct(Vm $vm)
    {
        $this->vm = $vm;
    }

    public function execute(): void
    {
        Http::asJson()
            ->post(config('services.discord.webhook_url'), [
                'username'   => config('services.discord.username'),
                'avatar_url' => 'https://media.discordapp.net/attachments/685636487550861355/907445691859759124/vsphere_logo.png',
                'embeds'     => [
                    [
                        'title'  => $this->getTitle(),
                        'color'  => $this->getColor(),
                        'fields' => [
                            [
                                'name'   => 'VM Name',
                                'value'  => $this->vm->name,
                                'inline' => true
                            ],
                            [
                                'name'   => 'Task ID',
                                'value'  => $this->vm->task_id,
                                'inline' => true
                            ],
                            [
                                'name'   => 'Destination',
                                'value'  => $this->vm->dstVcenter->host,
                                'inline' => true
                            ],
                            [
                                'name'  => 'Progress',
                                'value' => "{$this->vm->percentage}% Completed"
                            ]
                        ]
                    ]
                ]
            ]);
    }

    private function getColor(): int
    {
        switch ($this->vm->status){
            case Vm::STATUS_CLONING:
            case Vm::STATUS_MIGRATING:
                return 13931788;
            case Vm::STATUS_COMPLETED:
                return 840756;
            default:
                return 13899276;
        }
    }

    private function getTitle(): string
    {
        switch ($this->vm->status){
            case Vm::STATUS_CLONING:
                return ':cyclone: Cloning VM';
            case Vm::STATUS_MIGRATING:
                return ':rocket: Migrating VM';
            case Vm::STATUS_COMPLETED:
                return ':white_check_mark: Migration Completed';
            default:
                return ':warning: Migration Failed';
        }
    }
}
