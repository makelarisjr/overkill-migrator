$ErrorActionPreference = "SilentlyContinue";
$WarningPreference     = "SilentlyContinue";
$ProgressPreference    = "SilentlyContinue";

$data = $args[0] | ConvertFrom-Json;

Connect-VIServer -Server $data.src_vcenter.host -User $data.src_vcenter.user -Password $data.src_vcenter.password | Out-Null

$task = (Get-Task -Id $data.task_id)

Disconnect-VIServer * -Confirm:$false

Write-Output @{
    success=$true
    task=$task
} | ConvertTo-Json
