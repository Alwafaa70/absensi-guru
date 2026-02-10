# ============================================
# Setup Task Scheduler untuk Auto Bolos
# ============================================
# Script ini akan membuat 2 scheduled tasks:
# 1. Auto Bolos Datang (jam 07:31)
# 2. Auto Bolos Pulang (jam 16:01)
# ============================================

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Setup Task Scheduler - Auto Bolos" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Cek apakah running sebagai Administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "❌ ERROR: Script ini harus dijalankan sebagai Administrator!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Cara menjalankan sebagai Administrator:" -ForegroundColor Yellow
    Write-Host "1. Klik kanan pada PowerShell" -ForegroundColor Yellow
    Write-Host "2. Pilih 'Run as Administrator'" -ForegroundColor Yellow
    Write-Host "3. Jalankan script ini lagi" -ForegroundColor Yellow
    Write-Host ""
    Read-Host "Tekan Enter untuk keluar"
    exit 1
}

# Dapatkan path project saat ini
$projectPath = Get-Location
Write-Host "📁 Project Path: $projectPath" -ForegroundColor Green

# Cari path PHP
$phpPath = ""
$possiblePaths = @(
    "C:\xampp\php\php.exe",
    "C:\laragon\bin\php\php.exe",
    "C:\php\php.exe",
    "C:\wamp\bin\php\php.exe"
)

foreach ($path in $possiblePaths) {
    if (Test-Path $path) {
        $phpPath = $path
        break
    }
}

if ($phpPath -eq "") {
    Write-Host "❌ PHP tidak ditemukan di lokasi default!" -ForegroundColor Red
    $phpPath = Read-Host "Masukkan path lengkap ke php.exe"
    
    if (-not (Test-Path $phpPath)) {
        Write-Host "❌ Path PHP tidak valid!" -ForegroundColor Red
        Read-Host "Tekan Enter untuk keluar"
        exit 1
    }
}

Write-Host "✅ PHP ditemukan: $phpPath" -ForegroundColor Green
Write-Host ""

# Hapus task lama jika ada
Write-Host "🗑️  Menghapus task lama (jika ada)..." -ForegroundColor Yellow
try {
    Unregister-ScheduledTask -TaskName "Laravel Auto Bolos Datang" -Confirm:$false -ErrorAction SilentlyContinue
    Unregister-ScheduledTask -TaskName "Laravel Auto Bolos Pulang" -Confirm:$false -ErrorAction SilentlyContinue
} catch {
    # Ignore errors
}

Write-Host ""
Write-Host "📝 Membuat Task 1: Auto Bolos Datang (07:31)" -ForegroundColor Cyan

# Task 1: Auto Bolos Datang
$action1 = New-ScheduledTaskAction -Execute $phpPath -Argument "artisan absensi:auto-bolos datang" -WorkingDirectory $projectPath
$trigger1 = New-ScheduledTaskTrigger -Daily -At "07:31"
$principal1 = New-ScheduledTaskPrincipal -UserId "SYSTEM" -LogonType ServiceAccount -RunLevel Highest
$settings1 = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -StartWhenAvailable

Register-ScheduledTask -TaskName "Laravel Auto Bolos Datang" `
    -Action $action1 `
    -Trigger $trigger1 `
    -Principal $principal1 `
    -Settings $settings1 `
    -Description "Otomatis tandai guru bolos jika tidak absen datang sampai jam 07:30"

Write-Host "✅ Task 'Auto Bolos Datang' berhasil dibuat!" -ForegroundColor Green
Write-Host ""

Write-Host "📝 Membuat Task 2: Auto Bolos Pulang (16:01)" -ForegroundColor Cyan

# Task 2: Auto Bolos Pulang
$action2 = New-ScheduledTaskAction -Execute $phpPath -Argument "artisan absensi:auto-bolos pulang" -WorkingDirectory $projectPath
$trigger2 = New-ScheduledTaskTrigger -Daily -At "16:01"
$principal2 = New-ScheduledTaskPrincipal -UserId "SYSTEM" -LogonType ServiceAccount -RunLevel Highest
$settings2 = New-ScheduledTaskSettingsSet -AllowStartIfOnBatteries -DontStopIfGoingOnBatteries -StartWhenAvailable

Register-ScheduledTask -TaskName "Laravel Auto Bolos Pulang" `
    -Action $action2 `
    -Trigger $trigger2 `
    -Principal $principal2 `
    -Settings $settings2 `
    -Description "Otomatis tandai guru bolos jika tidak absen pulang sampai jam 16:00"

Write-Host "✅ Task 'Auto Bolos Pulang' berhasil dibuat!" -ForegroundColor Green
Write-Host ""

Write-Host "============================================" -ForegroundColor Green
Write-Host "✅ SETUP SELESAI!" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Task yang dibuat:" -ForegroundColor Cyan
Write-Host "  1. Laravel Auto Bolos Datang (07:31 setiap hari)" -ForegroundColor White
Write-Host "  2. Laravel Auto Bolos Pulang (16:01 setiap hari)" -ForegroundColor White
Write-Host ""
Write-Host "🔍 Cara melihat task:" -ForegroundColor Cyan
Write-Host "  1. Buka Task Scheduler (Win + R, ketik 'taskschd.msc')" -ForegroundColor White
Write-Host "  2. Lihat di Task Scheduler Library" -ForegroundColor White
Write-Host ""
Write-Host "🧪 Test task sekarang:" -ForegroundColor Cyan
Write-Host "  Start-ScheduledTask -TaskName 'Laravel Auto Bolos Datang'" -ForegroundColor Yellow
Write-Host "  Start-ScheduledTask -TaskName 'Laravel Auto Bolos Pulang'" -ForegroundColor Yellow
Write-Host ""
Write-Host "❌ Hapus task:" -ForegroundColor Cyan
Write-Host "  Unregister-ScheduledTask -TaskName 'Laravel Auto Bolos Datang'" -ForegroundColor Yellow
Write-Host "  Unregister-ScheduledTask -TaskName 'Laravel Auto Bolos Pulang'" -ForegroundColor Yellow
Write-Host ""

# Tanya apakah ingin test sekarang
$test = Read-Host "Apakah Anda ingin test task sekarang? (y/n)"
if ($test -eq "y" -or $test -eq "Y") {
    Write-Host ""
    Write-Host "🧪 Testing Auto Bolos Datang..." -ForegroundColor Cyan
    Start-ScheduledTask -TaskName "Laravel Auto Bolos Datang"
    Start-Sleep -Seconds 3
    Write-Host "✅ Task dijalankan! Cek database untuk melihat hasilnya." -ForegroundColor Green
    Write-Host ""
}

Write-Host "Tekan Enter untuk keluar..."
Read-Host
