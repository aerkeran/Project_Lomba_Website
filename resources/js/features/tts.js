/**
 * SpeakFun! pronunciation playback.
 *
 * 1. Ask the /tts route for the VoiceRSS MP3 (the API key stays on the server).
 * 2. If that fails — offline, quota exhausted, key missing — fall back to the
 *    browser's Web Speech API so a child can keep learning either way.
 *
 * A single "session" counter ties a playback to the click that started it, so
 * pressing stop never leaves a promise hanging or starts the fallback by accident.
 */

import { getVolume, onVolumeChange } from './volume.js';

let session = 0;
let activeRequest = null;
let activeAudio = null;
let activeUtterance = null;
let cancelPlayback = null;

/** Text -> object URL of the MP3 already downloaded in this page. */
const downloadedAudio = new Map();

export function supportsBrowserSpeech() {
    return 'speechSynthesis' in window && 'SpeechSynthesisUtterance' in window;
}

/** Stop whatever is playing right now. Safe to call when nothing is playing. */
export function stop() {
    session += 1;
    teardown();
}

/**
 * Read a word or phrase aloud in English.
 *
 * @param {string} text
 * @param {{ onPlay?: () => void }} [options] called once playback has actually started
 * @returns {Promise<'server' | 'browser'>} which source produced the audio
 */
export async function speak(text, options = {}) {
    const currentSession = ++session;
    const phrase = String(text ?? '').trim();

    teardown();

    if (phrase === '') {
        throw new Error('There is nothing to read aloud.');
    }

    try {
        await playServerAudio(phrase, options.onPlay);

        return 'server';
    } catch (serverError) {
        // The child pressed stop mid-flight: do not resurrect the audio.
        if (currentSession !== session) {
            throw serverError;
        }

        await playBrowserSpeech(phrase, options.onPlay);

        return 'browser';
    }
}

function endpointUrl() {
    return document.body?.dataset.ttsUrl ?? '/tts';
}

async function playServerAudio(phrase, onPlay) {
    const cached = downloadedAudio.get(phrase);

    if (cached) {
        return playElement(cached, onPlay);
    }

    const controller = new AbortController();
    activeRequest = controller;

    try {
        const response = await fetch(endpointUrl(), {
            method: 'GET',
            headers: { Accept: 'audio/mpeg, application/json' },
            signal: controller.signal,
        });

        if (!response.ok) {
            throw new Error(`Text-to-speech responded with ${response.status}.`);
        }

        const objectUrl = URL.createObjectURL(await response.blob());

        downloadedAudio.set(phrase, objectUrl);

        return await playElement(objectUrl, onPlay);
    } finally {
        if (activeRequest === controller) {
            activeRequest = null;
        }
    }
}

function playElement(objectUrl, onPlay) {
    return new Promise((resolve, reject) => {
        const audio = new Audio(objectUrl);

        audio.volume = getVolume() / 100;
        activeAudio = audio;

        const cleanup = () => {
            audio.removeEventListener('ended', handleEnded);
            audio.removeEventListener('error', handleError);

            if (activeAudio === audio) {
                activeAudio = null;
            }

            if (cancelPlayback === cancel) {
                cancelPlayback = null;
            }
        };

        const cancel = () => {
            cleanup();
            audio.pause();
            reject(new Error('Playback was stopped.'));
        };

        const handleEnded = () => {
            cleanup();
            resolve();
        };

        const handleError = () => {
            cleanup();
            reject(new Error('The audio could not be played.'));
        };

        cancelPlayback = cancel;

        audio.addEventListener('ended', handleEnded);
        audio.addEventListener('error', handleError);

        audio.play().then(() => onPlay?.()).catch((error) => {
            cleanup();
            reject(error);
        });
    });
}

function playBrowserSpeech(phrase, onPlay) {
    if (!supportsBrowserSpeech()) {
        return Promise.reject(new Error('This browser cannot read English words aloud.'));
    }

    return new Promise((resolve, reject) => {
        const utterance = new SpeechSynthesisUtterance(phrase);

        utterance.lang = 'en-US';
        utterance.volume = getVolume() / 100;

        const englishVoice = window.speechSynthesis
            .getVoices()
            .find((voice) => voice.lang.toLowerCase().startsWith('en'));

        if (englishVoice) {
            utterance.voice = englishVoice;
        }

        const settle = (callback, value) => {
            if (activeUtterance === utterance) {
                activeUtterance = null;
            }

            callback(value);
        };

        utterance.addEventListener('start', () => onPlay?.());
        utterance.addEventListener('end', () => settle(resolve, undefined));
        utterance.addEventListener('error', (event) => {
            settle(reject, new Error(event.error || 'The browser could not read this word.'));
        });

        activeUtterance = utterance;

        // Anything queued earlier would otherwise play after this utterance.
        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(utterance);
    });
}

function teardown() {
    if (cancelPlayback) {
        cancelPlayback();
    }

    if (activeRequest) {
        activeRequest.abort();
        activeRequest = null;
    }

    if (activeAudio) {
        activeAudio.pause();
        activeAudio.currentTime = 0;
        activeAudio = null;
    }

    if (supportsBrowserSpeech()) {
        window.speechSynthesis.cancel();
    }

    activeUtterance = null;
}

onVolumeChange((volume) => {
    const normalised = volume / 100;

    if (activeAudio) {
        activeAudio.volume = normalised;
    }

    if (activeUtterance) {
        activeUtterance.volume = normalised;
    }
});
