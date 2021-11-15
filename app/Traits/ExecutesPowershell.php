<?php

namespace App\Traits;

use App\Models\Vm;
use Symfony\Component\Process\Process;

trait ExecutesPowershell
{
    public function executePowershell(string $script): ?Vm
    {
        $process = new Process([
            '/usr/bin/pwsh',
            storage_path("app/powershell/${script}.ps1"),
            json_encode($this->vm)
        ]);

        $process->run();

        if (!$process->isSuccessful())
        {
            $err = $process->getErrorOutput();
            \Log::error("${script} failed with error code: {$process->getExitCode()}");
            \Log::error($err);

            $this->vm->update([
                'status' => Vm::STATUS_FAILED
            ]);

            return $this->vm;
        }

        $out  = $process->getOutput();
        $data = json_decode($out);

        \Log::debug($out);

        if ($data->task === null)
        {
            $this->vm->update([
                'status' => Vm::STATUS_FAILED
            ]);
        }
        else
        {
            if ($data->task->State === 3)
            {
                $this->vm->update([
                    'status' => Vm::STATUS_FAILED
                ]);
            }
            else
            {
                $this->vm->update([
                    'status'     =>
                        defined('static::SUCCESS_STATUS')
                            ? static::SUCCESS_STATUS
                            : $this->vm->getAttribute('status'),
                    'task_id'    => $data->task->Id,
                    'percentage' => $data->task->PercentComplete
                ]);
            }
        }

        return $this->vm;
    }
}
