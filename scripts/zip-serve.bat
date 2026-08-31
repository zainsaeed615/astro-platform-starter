@echo off
setlocal
set PORT=5500
cd /d "%~dp0"

echo.
echo   Mindfulness Candle Collection Mockup
echo   ------------------------------------
echo   Folder: %CD%
echo.

if not exist "index.html" (
  echo   ERROR: index.html not found in this folder.
  echo   Make sure you unzipped fully and run this file from the mockup root.
  pause
  exit /b 1
)

if not exist "_astro" (
  echo   ERROR: _astro folder not found. Re-download the latest zip file.
  pause
  exit /b 1
)

echo   Starting local preview server...
echo   Open: http://127.0.0.1:%PORT%/
echo   Press Ctrl+C to stop.
echo.

start "" "http://127.0.0.1:%PORT%/"

where py >nul 2>nul
if %ERRORLEVEL%==0 (
  py -m http.server %PORT% --bind 127.0.0.1
  goto :eof
)

where python >nul 2>nul
if %ERRORLEVEL%==0 (
  python -m http.server %PORT% --bind 127.0.0.1
  goto :eof
)

where npx >nul 2>nul
if %ERRORLEVEL%==0 (
  npx --yes serve -l %PORT% .
  goto :eof
)

echo   ERROR: Install Python 3 or Node.js, then double-click this file again.
pause
