@echo off
setlocal
set PORT=8080
cd /d "%~dp0"

echo.
echo   Mindfulness Candle Collection Mockup
echo   ------------------------------------
echo   Starting local preview server...
echo.

where python >nul 2>nul
if %ERRORLEVEL%==0 (
  echo   Open in your browser: http://localhost:%PORT%
  echo   Press Ctrl+C to stop.
  echo.
  start http://localhost:%PORT%
  python -m http.server %PORT%
  goto :eof
)

where py >nul 2>nul
if %ERRORLEVEL%==0 (
  echo   Open in your browser: http://localhost:%PORT%
  echo   Press Ctrl+C to stop.
  echo.
  start http://localhost:%PORT%
  py -m http.server %PORT%
  goto :eof
)

where npx >nul 2>nul
if %ERRORLEVEL%==0 (
  echo   Open in your browser: http://localhost:%PORT%
  echo   Press Ctrl+C to stop.
  echo.
  start http://localhost:%PORT%
  npx --yes serve -l %PORT% .
  goto :eof
)

echo   ERROR: Install Python or Node.js, then double-click this file again.
echo   Or open index.html directly (styles use relative paths).
pause
