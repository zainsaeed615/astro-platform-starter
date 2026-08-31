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
  pause
  exit /b 1
)

if not exist "images\mindfulness\hero-home.jpg" (
  echo   ERROR: images folder missing. Re-download the latest zip and unzip fully.
  pause
  exit /b 1
)

echo   Starting preview at http://127.0.0.1:%PORT%/
echo   Keep this window open while viewing.
echo.

where py >nul 2>nul
if %ERRORLEVEL%==0 (
  start /MIN "Mindfulness Server" cmd /c "py -m http.server %PORT% --bind 127.0.0.1"
  timeout /t 2 /nobreak > nul
  start "" "http://127.0.0.1:%PORT%/"
  echo   Server running. Press any key to stop...
  pause > nul
  goto :eof
)

where python >nul 2>nul
if %ERRORLEVEL%==0 (
  start /MIN "Mindfulness Server" cmd /c "python -m http.server %PORT% --bind 127.0.0.1"
  timeout /t 2 /nobreak > nul
  start "" "http://127.0.0.1:%PORT%/"
  echo   Server running. Press any key to stop...
  pause > nul
  goto :eof
)

echo   Python not found. Opening index.html directly instead...
start "" "%CD%\index.html"
pause
