$ErrorActionPreference = "SilentlyContinue";
$WarningPreference     = "SilentlyContinue";
$ProgressPreference    = "SilentlyContinue";

$data = $args[0] | ConvertFrom-Json;

$src = (Connect-VIServer -Server $data.src_vcenter.host -User $data.src_vcenter.user -Password $data.src_vcenter.password);

$originalVm = (Get-VM -Server $src -Name $data.name);
# always clone the original vm
# we don't want to break the original :P
$vm = (New-VM -Name "$($data.name)-migrate" -VM $originalVm -VMHost $data.src_vcenter.esxi -Location "Migrate" -DiskStorageFormat "Thin" -Server $src -RunAsync)

Disconnect-VIServer * -Confirm:$false

Write-Output @{
    success=$true
    task=$vm
} | ConvertTo-Json
