/**
 * SpeakFun! front-end entry point.
 *
 * Buttons use delegation rather than per-element listeners, so Blade views can
 * render audio buttons anywhere without remembering to boot a module.
 */

import { registerAudioButtons } from './features/audio-button.js';
import { getVolume, initVolumeSliders, setVolume } from './features/volume.js';

function boot() {
    registerAudioButtons();
    initVolumeSliders();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}

// Exposed for screens that build controls in JavaScript (e.g. the quiz).
window.SpeakFun = { getVolume, setVolume, initVolumeSliders };
