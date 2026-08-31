#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
STAGING="/tmp/mindfulness-zip-staging"
OUT="/opt/cursor/artifacts/mindfulness-candle-mockup.zip"

echo "Building Mindfulness mockup zip..."

rm -rf "$STAGING"
mkdir -p "$STAGING"
cp -r "$ROOT/src" "$ROOT/public" "$ROOT/package.json" "$ROOT/package-lock.json" \
  "$ROOT/astro.config.mjs" "$ROOT/tsconfig.json" "$ROOT/scripts/fix-zip-paths.mjs" "$STAGING/"

cd "$STAGING"
rm -rf src/pages/api src/pages/blobs src/pages/edge src/pages/image-cdn src/pages/revalidation.astro

npm ci --silent
ZIP_DEPLOY=true npm run build --silent
node fix-zip-paths.mjs dist

cp "$ROOT/scripts/zip-README.txt" dist/README.txt
cp "$ROOT/scripts/zip-serve.bat" dist/START-MOCKUP.bat
cp "$ROOT/scripts/zip-serve.sh" dist/START-MOCKUP.sh
chmod +x dist/START-MOCKUP.sh

mkdir -p "$(dirname "$OUT")"
rm -f "$OUT"
(cd dist && zip -r "$OUT" .)

echo ""
echo "Zip created: $OUT"
ls -lh "$OUT"
