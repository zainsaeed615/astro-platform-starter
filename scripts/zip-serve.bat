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

echo   Opening mockup in your default browser...
echo.
echo   OPTION A: Opening index.html directly (styles are embedded)
start "" "%CD%\index.html"

echo.
echo   OPTION B: Starting local server at http://127.0.0.1:%PORT%/
echo   (Better for full navigation between pages)
echo.

where py >nul 2>nul
if %ERRORLEVEL%==0 (
  start /MIN "Mindfulness Server" cmd /c "py -m http.server %PORT% --bind 127.0.0.1"
  timeout /t 2 /nobreak > nul
  start "" "http://127.0.0.1:%PORT%/"
  echo   Server running in minimized window. Close it when finished.
  pause
  goto :eof
)

where python >nul 2>nul
if %ERRORLEVEL%==0 (
  start /MIN "Mindfulness Server" cmd /c "python -m http.server %PORT% --bind 127.0.0.1"
  timeout /t 2 /nobreak > nul
  start "" "http://127.0.0.1:%PORT%/"
  echo   Server running in minimized window. Close it when finished.
  pause
  goto :eof
)

echo   Python not found. index.html was opened directly with embedded styles.
pause
