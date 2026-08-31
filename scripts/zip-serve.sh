#!/usr/bin/env bash
# Start a local server to preview the Mindfulness mockup.
# Requires Python 3 (preinstalled on macOS/Linux) or Node.js.

PORT="${1:-5500}"
DIR="$(cd "$(dirname "$0")" && pwd)"

echo ""
echo "  Mindfulness Candle Collection Mockup"
echo "  ------------------------------------"
echo "  Starting local preview server..."
echo ""

cd "$DIR"

if command -v python3 >/dev/null 2>&1; then
  echo "  Open in your browser: http://localhost:${PORT}"
  echo "  Press Ctrl+C to stop."
  echo ""
  python3 -m http.server "$PORT"
elif command -v python >/dev/null 2>&1; then
  echo "  Open in your browser: http://localhost:${PORT}"
  echo "  Press Ctrl+C to stop."
  echo ""
  python -m http.server "$PORT"
elif command -v npx >/dev/null 2>&1; then
  echo "  Open in your browser: http://localhost:${PORT}"
  echo "  Press Ctrl+C to stop."
  echo ""
  npx --yes serve -l "$PORT" .
else
  echo "  ERROR: Install Python 3 or Node.js, then run this script again."
  echo "  Or open index.html after unzipping (styles should load with relative paths)."
  exit 1
fi
