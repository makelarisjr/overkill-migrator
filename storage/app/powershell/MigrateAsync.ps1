$ErrorActionPreference = "SilentlyContinue";
$WarningPreference     = "SilentlyContinue";
$ProgressPreference    = "SilentlyContinue";

$data = $args[0] | ConvertFrom-Json;

$src = (Connect-VIServer -Server $data.src_vcenter.host -User $data.src_vcenter.user -Password $data.src_vcenter.password);
$dst = (Connect-VIServer -Server $data.dst_vcenter.host -User $data.dst_vcenter.user -Password $data.dst_vcenter.password);

# migrate the cloned vm
$vm = (Get-VM -Server $src -Name "$($data.name)-migrate");

$dstEsxi        = (Get-VMHost -Server $dst -Name $data.dst_vcenter.esxi);
$networkAdapter = (Get-NetworkAdapter -Server $src -VM $vm);
$dstDatastore   = (Get-Datastore -Server $dst -Name $data.dst_vcenter.datastore);

# we'll use the "default" port group
$portGroup = (Get-VirtualPortGroup -Server $dst -Name "VM Network")
$task = (Move-VM -VM $vm -Destination $dstEsxi -Datastore $dstDatastore -NetworkAdapter $networkAdapter -PortGroup $portGroup -RunAsync);

Disconnect-VIServer * -Confirm:$false

Write-Output @{
    success=$true
    task=$task
} | ConvertTo-Json
