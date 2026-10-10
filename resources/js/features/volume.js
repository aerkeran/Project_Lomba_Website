/**
 * Website volume (PRD FR-08). One value drives both audio paths: the <audio>
 * element used for VoiceRSS MP3s and the Web Speech fallback, so the slider in
 * Settings always matches what a child hears.
 */

const STORAGE_KEY = 'speakfun:volume';
const VOLUME_EVENT = 'speakfun:volume';
const DEFAULT_VOLUME = 100;

function readStoredVolume() {
    try {
        return window.localStorage.getItem(STORAGE_KEY);
    } catch {
        // Storage can be unavailable in private browsing; volume then just resets.
        return null;
    }
}

function writeStoredVolume(volume) {
    try {
        window.localStorage.setItem(STORAGE_KEY, String(volume));
    } catch {
        // Nothing to do — the volume still applies for this visit.
    }
}

function clamp(volume) {
    const parsed = Number.parseInt(String(volume), 10);

    if (Number.isNaN(parsed)) {
        return DEFAULT_VOLUME;
    }

    return Math.min(100, Math.max(0, parsed));
}

/** @returns {number} volume from 0 to 100 */
export function getVolume() {
    const stored = readStoredVolume();

    return stored === null ? DEFAULT_VOLUME : clamp(stored);
}

/** @param {number} volume volume from 0 to 100 */
export function setVolume(volume) {
    const next = clamp(volume);

    writeStoredVolume(next);
    window.dispatchEvent(new CustomEvent(VOLUME_EVENT, { detail: { volume: next } }));

    return next;
}

export function onVolumeChange(handler) {
    window.addEventListener(VOLUME_EVENT, (event) => handler(event.detail.volume));
}

/**
 * Wires every slider marked with `data-volume-slider` to the stored volume.
 * The matching `data-volume-output` element shows the number next to it.
 */
export function initVolumeSliders(root = document) {
    const volume = getVolume();

    root.querySelectorAll('[data-volume-slider]').forEach((slider) => {
        slider.value = String(volume);
        updateOutput(slider, volume);

        if (slider.dataset.volumeSliderReady === 'true') {
            return;
        }

        slider.dataset.volumeSliderReady = 'true';

        slider.addEventListener('input', () => {
            const next = setVolume(slider.value);

            root.querySelectorAll('[data-volume-slider]').forEach((other) => {
                other.value = String(next);
                updateOutput(other, next);
            });
        });
    });
}

function updateOutput(slider, volume) {
    const scope = slider.closest('[data-volume-group]') ?? slider.parentElement;
    const output = scope?.querySelector('[data-volume-output]');

    if (output) {
        output.textContent = `${volume}%`;
    }
}
