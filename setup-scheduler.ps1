# ============================================
# Setup Windows Task Scheduler untuk Laravel
# ============================================
# Script ini akan membuat scheduled task di Windows
# yang menjalankan Laravel scheduler setiap menit

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setup Laravel Scheduler di Windows" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$projectPath = Split-Path -Parent $MyInvocation.MyCommand.Path
$phpPath = (Get-Command php).Source
$taskName = "Laravel Scheduler - Absensi Guru"

Write-Host "Project Path: $projectPath" -ForegroundColor Yellow
Write-Host "PHP Path: $phpPath" -ForegroundColor Yellow
Write-Host ""

# Cek apakah task sudah ada
$existingTask = Get-ScheduledTask -TaskName $taskName -ErrorAction SilentlyContinue

if ($existingTask) {
    Write-Host "Task sudah ada. Menghapus task lama..." -ForegroundColor Yellow
    Unregister-ScheduledTask -TaskName $taskName -Confirm:$false
}

# Buat action untuk menjalankan artisan schedule:run
$action = New-ScheduledTaskAction -Execute $phpPath -Argument "artisan schedule:run" -WorkingDirectory $projectPath

# Buat trigger untuk menjalankan setiap menit
$trigger = New-ScheduledTaskTrigger -Once -At (Get-Date) -RepetitionInterval (New-TimeSpan -Minutes 1) -RepetitionDuration ([TimeSpan]::MaxValue)

# Buat principal (user yang menjalankan task)
$principal = New-ScheduledTaskPrincipal -UserId "$env:USERDOMAIN\$env:USERNAME" -LogonType S4U

# Buat settings
$settings = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -StartWhenAvailable -RunOnlyIfNetworkAvailable:$false -MultipleInstances IgnoreNew

# Register task
try {
    Register-ScheduledTask -TaskName $taskName -Action $action -Trigger $trigger -Principal $principal -Settings $settings -Description "Menjalankan Laravel scheduler untuk sistem absensi guru setiap menit"
    
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "✓ Task Scheduler berhasil dibuat!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Task Name: $taskName" -ForegroundColor Cyan
    Write-Host "Interval: Setiap 1 menit" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Auto-bolos akan berjalan otomatis pada:" -ForegroundColor Yellow
    Write-Host "  - Jam 07:31 (untuk yang tidak absen datang)" -ForegroundColor White
    Write-Host "  - Jam 16:01 (untuk yang tidak absen pulang)" -ForegroundColor White
    Write-Host ""
    Write-Host "Untuk melihat task, buka Task Scheduler dan cari:" -ForegroundColor Cyan
    Write-Host "  '$taskName'" -ForegroundColor White
    Write-Host ""
    
} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "✗ Gagal membuat task!" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "Solusi:" -ForegroundColor Yellow
    Write-Host "1. Jalankan PowerShell sebagai Administrator" -ForegroundColor White
    Write-Host "2. Jalankan script ini lagi" -ForegroundColor White
    Write-Host ""
}

Write-Host "Tekan tombol apa saja untuk keluar..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
