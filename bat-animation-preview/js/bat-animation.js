/**
 * Standalone bat animation (no build step, works from folder).
 */
class BatAnimation {
    constructor(canvas, imageSrc, options = {}) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d', { alpha: false });
        this.imageSrc = imageSrc;
        this.options = {
            skyHeightRatio: 0.48,
            luminanceThreshold: 72,
            contrastDelta: 18,
            minBatArea: 80,
            maxBatArea: 18000,
            minDetectedBats: 8,
            padding: 8,
            ...options
        };

        this.image = new Image();
        this.image.decoding = 'async';
        this.backgroundCanvas = document.createElement('canvas');
        this.backgroundCtx = this.backgroundCanvas.getContext('2d');
        this.bats = [];
        this.running = false;
        this.startTime = 0;
        this.rafId = 0;
    }

    async init() {
        await this.loadImage(this.image, this.imageSrc);
        const { width, height } = this.image;
        this.canvas.width = width;
        this.canvas.height = height;
        this.backgroundCanvas.width = width;
        this.backgroundCanvas.height = height;

        this.bats = this.detectBats(width, height);
        if (this.bats.length < this.options.minDetectedBats) {
            this.bats = this.fallbackBats(width, height);
        }

        this.buildBackground();
        this.drawFrame(0);
        return this.bats.length;
    }

    start() {
        if (this.running) return;
        this.running = true;
        this.startTime = performance.now();
        const tick = (now) => {
            if (!this.running) return;
            this.drawFrame((now - this.startTime) / 1000);
            this.rafId = requestAnimationFrame(tick);
        };
        this.rafId = requestAnimationFrame(tick);
    }

    stop() {
        this.running = false;
        cancelAnimationFrame(this.rafId);
    }

    drawFrame(time) {
        const ctx = this.ctx;
        const { width, height } = this.canvas;

        ctx.drawImage(this.backgroundCanvas, 0, 0);

        for (const bat of this.bats) {
            const flap = Math.sin(time * bat.flapSpeed + bat.phase);
            const driftX = Math.sin(time * bat.driftSpeed + bat.phase * 1.7) * bat.driftAmount;
            const driftY = Math.cos(time * bat.driftSpeed * 0.85 + bat.phase) * bat.driftAmount * 0.55;
            const scaleY = 0.82 + (flap + 1) * 0.11;
            const scaleX = 1 + flap * 0.03;
            const rotate = Math.sin(time * bat.driftSpeed * 0.6 + bat.phase) * 0.06;

            const centerX = bat.x + bat.w / 2 + driftX;
            const centerY = bat.y + bat.h / 2 + driftY;

            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(rotate);
            ctx.scale(scaleX, scaleY);
            ctx.drawImage(this.image, bat.x, bat.y, bat.w, bat.h, -bat.w / 2, -bat.h / 2, bat.w, bat.h);
            ctx.restore();
        }

        if (this.options.debug) {
            ctx.fillStyle = 'rgba(255, 120, 0, 0.85)';
            ctx.font = '14px sans-serif';
            ctx.fillText(`Bats: ${this.bats.length}`, 16, height - 16);
        }
    }

    loadImage(image, src) {
        return new Promise((resolve, reject) => {
            image.onload = () => resolve();
            image.onerror = () => reject(new Error(`Failed to load image: ${src}`));
            image.src = src;
        });
    }

    detectBats(width, height) {
        const scanHeight = Math.floor(height * this.options.skyHeightRatio);
        const probe = document.createElement('canvas');
        probe.width = width;
        probe.height = height;
        const probeCtx = probe.getContext('2d', { willReadFrequently: true });
        probeCtx.drawImage(this.image, 0, 0);
        const { data } = probeCtx.getImageData(0, 0, width, scanHeight);

        const luminance = new Float32Array(width * scanHeight);
        for (let y = 0; y < scanHeight; y++) {
            for (let x = 0; x < width; x++) {
                const i = (y * width + x) * 4;
                luminance[y * width + x] = 0.2126 * data[i] + 0.7152 * data[i + 1] + 0.0722 * data[i + 2];
            }
        }

        const mask = new Uint8Array(width * scanHeight);
        const window = 7;
        const half = Math.floor(window / 2);

        for (let y = 0; y < scanHeight; y++) {
            for (let x = 0; x < width; x++) {
                let sum = 0;
                let count = 0;
                for (let oy = -half; oy <= half; oy++) {
                    for (let ox = -half; ox <= half; ox++) {
                        const nx = x + ox;
                        const ny = y + oy;
                        if (nx < 0 || ny < 0 || nx >= width || ny >= scanHeight) continue;
                        sum += luminance[ny * width + nx];
                        count++;
                    }
                }

                const localAvg = sum / count;
                const value = luminance[y * width + x];
                if (value <= this.options.luminanceThreshold && value <= localAvg - this.options.contrastDelta) {
                    mask[y * width + x] = 1;
                }
            }
        }

        const visited = new Uint8Array(width * scanHeight);
        const bats = [];

        for (let y = 0; y < scanHeight; y++) {
            for (let x = 0; x < width; x++) {
                const idx = y * width + x;
                if (!mask[idx] || visited[idx]) continue;

                const region = this.floodFill(mask, visited, width, scanHeight, x, y);
                const area = region.length;
                if (area < this.options.minBatArea || area > this.options.maxBatArea) continue;

                let minX = width;
                let minY = scanHeight;
                let maxX = 0;
                let maxY = 0;
                for (const point of region) {
                    const px = point % width;
                    const py = Math.floor(point / width);
                    minX = Math.min(minX, px);
                    minY = Math.min(minY, py);
                    maxX = Math.max(maxX, px);
                    maxY = Math.max(maxY, py);
                }

                const w = maxX - minX + 1;
                const h = maxY - minY + 1;
                const aspect = w / h;
                if (aspect < 0.8 || aspect > 5.5) continue;

                bats.push(this.createBat(minX, minY, w, h, bats.length));
            }
        }

        return bats.sort((a, b) => a.y - b.y || a.x - b.x);
    }

    floodFill(mask, visited, width, height, startX, startY) {
        const stack = [startY * width + startX];
        const region = [];

        while (stack.length) {
            const idx = stack.pop();
            if (visited[idx] || !mask[idx]) continue;
            visited[idx] = 1;
            region.push(idx);

            const x = idx % width;
            const y = Math.floor(idx / width);
            if (x > 0) stack.push(idx - 1);
            if (x < width - 1) stack.push(idx + 1);
            if (y > 0) stack.push(idx - width);
            if (y < height - 1) stack.push(idx + width);
        }

        return region;
    }

    createBat(x, y, w, h, index) {
        const pad = this.options.padding;
        return {
            x: Math.max(0, x - pad),
            y: Math.max(0, y - pad),
            w: w + pad * 2,
            h: h + pad * 2,
            phase: index * 1.35,
            flapSpeed: 5.8 + (index % 4) * 0.45,
            driftSpeed: 0.55 + (index % 5) * 0.12,
            driftAmount: 2 + (index % 3)
        };
    }

    fallbackBats(width, height) {
        const presets = [
            [0.055, 0.055, 0.085, 0.06],
            [0.115, 0.095, 0.065, 0.048],
            [0.165, 0.045, 0.09, 0.065],
            [0.205, 0.125, 0.055, 0.04],
            [0.245, 0.08, 0.045, 0.032],
            [0.565, 0.055, 0.055, 0.04],
            [0.625, 0.095, 0.07, 0.05],
            [0.685, 0.06, 0.06, 0.042],
            [0.745, 0.115, 0.055, 0.038],
            [0.805, 0.075, 0.05, 0.035],
            [0.865, 0.13, 0.045, 0.032],
            [0.915, 0.085, 0.04, 0.03],
            [0.515, 0.155, 0.038, 0.028],
            [0.385, 0.095, 0.034, 0.026]
        ];

        return presets.map(([rx, ry, rw, rh], index) =>
            this.createBat(Math.round(rx * width), Math.round(ry * height), Math.round(rw * width), Math.round(rh * height), index)
        );
    }

    buildBackground() {
        const ctx = this.backgroundCtx;
        ctx.drawImage(this.image, 0, 0);

        for (const bat of this.bats) {
            const sampleY = Math.max(0, bat.y - Math.max(24, bat.h * 1.5));
            const sampleH = Math.max(18, bat.h);
            ctx.save();
            ctx.filter = 'blur(10px)';
            ctx.globalAlpha = 0.95;
            ctx.drawImage(this.image, bat.x, sampleY, bat.w, sampleH, bat.x - 2, bat.y - 1, bat.w + 4, bat.h + 2);
            ctx.restore();

            ctx.save();
            ctx.filter = 'blur(6px)';
            ctx.globalAlpha = 0.55;
            ctx.drawImage(this.image, bat.x, sampleY, bat.w, sampleH, bat.x, bat.y, bat.w, bat.h);
            ctx.restore();
        }
    }
}

function initBatAnimation(selector = '[data-bat-animation]') {
    const canvas = document.querySelector(selector);
    if (!(canvas instanceof HTMLCanvasElement)) return null;

    const imageSrc = canvas.dataset.image;
    if (!imageSrc) return null;

    const animation = new BatAnimation(canvas, imageSrc, {
        debug: canvas.dataset.debug === 'true'
    });

    animation.init().then(() => animation.start());
    return animation;
}

window.BatAnimation = BatAnimation;
window.initBatAnimation = initBatAnimation;
