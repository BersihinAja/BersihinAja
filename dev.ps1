# BersihinAja - Local Development Starter
# Usage: .\dev.ps1          (start all)
#        .\dev.ps1 stop     (stop all)
#        .\dev.ps1 restart  (restart all)
#        .\dev.ps1 status   (check status)
#        .\dev.ps1 migrate  (run migrations)
#        .\dev.ps1 seed     (run seeders)
#        .\dev.ps1 fresh    (reset DB + seed)

param(
    [Parameter(Position=0)]
    [ValidateSet("start", "stop", "restart", "status", "migrate", "seed", "fresh")]
    [string]$Action = "start"
)

$ProjectDir = "f:\Project\BersihinAja"
$PhpPath = "C:\Users\eleonorez\php"
$env:Path = "$PhpPath;C:\Program Files\PostgreSQL\17\bin;" + $env:Path

Write-Host ""
Write-Host "  ========================================" -ForegroundColor Cyan
Write-Host "  BersihinAja Dev Server" -ForegroundColor Cyan
Write-Host "  ========================================" -ForegroundColor Cyan
Write-Host ""

function Stop-DevServers {
    Write-Host "  Stopping servers..." -ForegroundColor Yellow
    Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    Get-Process -Name "node" -ErrorAction SilentlyContinue | Where-Object {
        try { $_.CommandLine -like "*vite*" } catch { $false }
    } | Stop-Process -Force -ErrorAction SilentlyContinue
    Write-Host "  [OK] Servers stopped" -ForegroundColor Green
}

function Start-DevServers {
    Set-Location $ProjectDir

    $pg = Get-Service -Name "postgresql*" -ErrorAction SilentlyContinue
    if ($pg -and $pg.Status -eq "Running") {
        Write-Host "  [OK] PostgreSQL running" -ForegroundColor Green
    } else {
        Write-Host "  [ERR] PostgreSQL not running!" -ForegroundColor Red
        Write-Host "    Run: Start-Service postgresql-x64-17" -ForegroundColor Gray
        return
    }

    $phpVer = & php -r "echo PHP_VERSION;" 2>$null
    if ($phpVer) {
        Write-Host "  [OK] PHP $phpVer" -ForegroundColor Green
    } else {
        Write-Host "  [ERR] PHP not found!" -ForegroundColor Red
        return
    }

    Write-Host ""
    Write-Host "  Starting Laravel server..." -ForegroundColor Cyan
    Start-Process -FilePath "php" -ArgumentList "artisan","serve" -WorkingDirectory $ProjectDir -WindowStyle Normal

    Write-Host "  Starting Vite dev server..." -ForegroundColor Cyan
    Start-Process -FilePath "cmd" -ArgumentList "/c","npm run dev" -WorkingDirectory $ProjectDir -WindowStyle Normal

    Start-Sleep -Seconds 2

    Write-Host ""
    Write-Host "  ========================================" -ForegroundColor Green
    Write-Host "  Dev servers running!" -ForegroundColor Green
    Write-Host "  ========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "  App:    http://localhost:8000" -ForegroundColor White
    Write-Host "  Vite:   http://localhost:5173" -ForegroundColor White
    Write-Host ""
    Write-Host "  Admin:  admin@bersihinaja.com / password" -ForegroundColor Gray
    Write-Host ""
    Write-Host "  Stop:   .\dev.ps1 stop" -ForegroundColor Gray
    Write-Host ""
}

function Show-Status {
    $phpProc = Get-Process -Name "php" -ErrorAction SilentlyContinue
    $nodeProc = Get-Process -Name "node" -ErrorAction SilentlyContinue
    $pg = Get-Service -Name "postgresql*" -ErrorAction SilentlyContinue

    if ($pg -and $pg.Status -eq "Running") {
        Write-Host "  PostgreSQL:  [OK] Running" -ForegroundColor Green
    } else {
        Write-Host "  PostgreSQL:  [--] Stopped" -ForegroundColor Red
    }

    if ($phpProc) {
        Write-Host "  PHP Server:  [OK] Running" -ForegroundColor Green
    } else {
        Write-Host "  PHP Server:  [--] Stopped" -ForegroundColor Red
    }

    if ($nodeProc) {
        Write-Host "  Vite:        [OK] Running" -ForegroundColor Green
    } else {
        Write-Host "  Vite:        [--] Stopped" -ForegroundColor Red
    }
}

switch ($Action) {
    "start"   { Start-DevServers }
    "stop"    { Stop-DevServers }
    "restart" { Stop-DevServers; Start-Sleep -Seconds 1; Start-DevServers }
    "status"  { Show-Status }
    "migrate" {
        Set-Location $ProjectDir
        & php artisan migrate
    }
    "seed" {
        Set-Location $ProjectDir
        & php artisan db:seed
    }
    "fresh" {
        Set-Location $ProjectDir
        Write-Host "  Resetting database..." -ForegroundColor Yellow
        & php artisan migrate:fresh --seed
        Write-Host "  [OK] Database reset complete" -ForegroundColor Green
    }
}
