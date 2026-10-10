/**
 * Wires every pronunciation button (DESIGN.md §17) through event delegation,
 * so buttons created later — for example the next quiz question — work without
 * being initialised by hand.
 *
 * States: idle -> loading -> speaking -> done, or error when nothing can play.
 */

import { setVolume } from './volume.js';
import { speak, stop } from './tts.js';

const STATE_LABELS = {
    idle: 'labelIdle',
    loading: 'labelLoading',
    speaking: 'labelSpeaking',
    done: 'labelDone',
    error: 'labelError',
};

const STATUS_HIDE_DELAY = 6000;

/** Buttons are tracked with a WeakMap so delegated clicks stay per-button safe. */
const generations = new WeakMap();

let registered = false;
let statusTimer = null;

/**
 * Register the delegated listeners once. The guard matters: two listeners on
 * the same click would start the audio and immediately stop it again.
 */
export function registerAudioButtons() {
    if (registered) {
        return;
    }

    registered = true;

    document.addEventListener('click', handleClick);
    document.addEventListener('input', handleVolumeInput);
}

function handleClick(event) {
    const button = event.target instanceof Element ? event.target.closest('[data-audio-button]') : null;

    if (!button) {
        return;
    }

    const generation = (generations.get(button) ?? 0) + 1;
    generations.set(button, generation);

    // A second press while audio runs means "stop" — friendlier than forcing a
    // child to listen to the whole word again (PRD FR-03 allows unlimited replays).
    if (button.dataset.state === 'loading' || button.dataset.state === 'speaking') {
        stop();
        setState(button, 'idle');

        return;
    }

    setState(button, 'loading');

    speak(button.dataset.text, {
        onPlay: () => applyStateIfCurrent(button, generation, 'speaking'),
    })
        .then(() => applyStateIfCurrent(button, generation, 'done'))
        .catch(() => {
            if (!isCurrent(button, generation)) {
                return;
            }

            setState(button, 'error');
            showStatus('Audio is not available right now. You can continue learning without it.');
        });
}

function applyStateIfCurrent(button, generation, state) {
    if (isCurrent(button, generation)) {
        setState(button, state);
    }
}

function isCurrent(button, generation) {
    return generations.get(button) === generation;
}

function setState(button, state) {
    button.dataset.state = state;

    const key = STATE_LABELS[state] ?? STATE_LABELS.idle;
    const text = button.dataset[key] || button.dataset.labelIdle || 'Listen';
    const label = button.querySelector('.sf-audio-button__label');

    if (label) {
        label.textContent = text;
    }

    button.setAttribute('aria-label', text);

    if (state === 'loading') {
        button.setAttribute('aria-busy', 'true');
    } else {
        button.removeAttribute('aria-busy');
    }
}

function showStatus(message) {
    const region = document.getElementById('sf-tts-status');

    if (!region) {
        return;
    }

    region.textContent = message;

    if (statusTimer) {
        window.clearTimeout(statusTimer);
    }

    statusTimer = window.setTimeout(() => {
        region.textContent = '';
        statusTimer = null;
    }, STATUS_HIDE_DELAY);
}

/* Volume sliders live in Settings but are wired here so that screen needs no inline script. */
function handleVolumeInput(event) {
    const slider = event.target instanceof Element ? event.target.closest('[data-volume-slider]') : null;

    if (slider) {
        setVolume(slider.value);
    }
}
