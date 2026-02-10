@echo off
REM ============================================
REM Laravel Scheduler Runner untuk Windows
REM ============================================
REM File ini akan menjalankan Laravel scheduler setiap menit
REM Simpan file ini dan jalankan terus menerus di background

echo ========================================
echo Laravel Scheduler Runner
echo ========================================
echo.
echo Scheduler sedang berjalan...
echo Tekan Ctrl+C untuk menghentikan
echo.
echo ========================================
echo.

:loop
php artisan schedule:run >> NUL 2>&1
timeout /t 60 /nobreak > NUL
goto loop
