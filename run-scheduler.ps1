# ============================================
# Laravel Scheduler Runner (PowerShell)
# ============================================
# Script ini akan menjalankan Laravel scheduler setiap menit

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Laravel Scheduler Runner" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Scheduler sedang berjalan..." -ForegroundColor Green
Write-Host "Tekan Ctrl+C untuk menghentikan" -ForegroundColor Yellow
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$scriptPath = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $scriptPath

while ($true) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$timestamp] Running scheduler..." -ForegroundColor Gray
    
    php artisan schedule:run 2>&1 | Out-Null
    
    Start-Sleep -Seconds 60
}
