/**
 * Drives the three learning activities (PRD §6.5 Materi, §6.6 Latihan, §6.7 Kuis).
 *
 * The whole level is already in the page as a hidden <ol>, so moving between
 * words swaps text, images and visibility instead of reloading: on a phone a
 * reload between every word would put a visible pause in front of a child, and
 * the audio pipeline is JavaScript-only anyway.
 *
 * The audio button needs no special handling here — audio-button.js listens on
 * the document, so it keeps working while this module rewrites data-text.
 */

import { cancelAudioButton } from './audio-button.js';

export function initLesson() {
    const root = document.querySelector('[data-lesson]');

    if (!root) {
        return;
    }

    const items = [...root.querySelectorAll('[data-lesson-items] [data-item]')].map((element) => ({
        english: element.dataset.english ?? '',
        indonesia: element.dataset.indonesia ?? '',
        image: element.dataset.image ?? '',
    }));

    if (items.length === 0) {
        return;
    }

    const isQuiz = root.dataset.activity === 'kuis';
    const menuUrl = root.dataset.menuUrl;
    const total = items.length;

    const progress = root.querySelector('[data-lesson-progress]');
    const form = root.querySelector('[data-lesson-form]');

    const parts = {
        image: root.querySelector('[data-lesson-image]'),
        word: root.querySelector('[data-lesson-word]'),
        caption: root.querySelector('[data-lesson-caption]'),
        audio: root.querySelector('[data-lesson-audio]'),
        prev: root.querySelector('[data-lesson-prev]'),
        next: root.querySelector('[data-lesson-next]'),
        nextLabel: root.querySelector('[data-lesson-next-label]'),
        nextEmoji: root.querySelector('[data-lesson-next-emoji]'),
        input: root.querySelector('[data-lesson-input]'),
        reveal: root.querySelector('[data-lesson-reveal]'),
        count: progress?.querySelector('[data-progress-count]'),
        bar: progress?.querySelector('[role="progressbar"]'),
        fill: progress?.querySelector('[data-progress-fill]'),
        feedback: {
            correct: root.querySelector('[data-lesson-feedback="correct"]'),
            wrong: root.querySelector('[data-lesson-feedback="wrong"]'),
            prompt: root.querySelector('[data-lesson-feedback="prompt"]'),
        },
    };

    let index = 0;
    let answered = false;

    function showFeedback(name) {
        for (const [key, element] of Object.entries(parts.feedback)) {
            setVisible(element, key === name);
        }
    }

    function resetAnswer() {
        if (parts.input) {
            parts.input.value = '';
        }

        showFeedback(null);
        setVisible(parts.reveal, false);
        answered = false;
    }

    function renderNav() {
        const atEnd = index === total - 1;

        if (parts.prev) {
            parts.prev.disabled = index === 0;
        }

        // A quiz only offers the way forward once the answer is right (PRD §6.7).
        setVisible(parts.next, !isQuiz || answered);

        if (parts.nextLabel) {
            parts.nextLabel.textContent = atEnd ? 'Finish' : 'Next';
        }

        setVisible(parts.nextEmoji, atEnd);
    }

    function render() {
        const item = items[index];

        if (parts.image) {
            parts.image.src = item.image;
            parts.image.alt = item.english;
        }

        if (parts.word) {
            parts.word.textContent = capitalise(item.english);
        }

        if (parts.caption) {
            parts.caption.textContent = item.indonesia;
        }

        if (parts.audio) {
            parts.audio.dataset.text = item.english;
        }

        resetAnswer();

        const current = index + 1;

        if (parts.count) {
            parts.count.textContent = `${current} / ${total}`;
        }

        if (parts.bar) {
            parts.bar.setAttribute('aria-valuenow', String(current));
            parts.bar.setAttribute('aria-valuemax', String(total));
        }

        if (parts.fill) {
            parts.fill.style.width = `${Math.round((current / total) * 100)}%`;
        }

        renderNav();
    }

    function goTo(nextIndex) {
        // Leaving a word must not leave its pronunciation running behind us.
        cancelAudioButton(parts.audio);

        index = Math.min(Math.max(nextIndex, 0), total - 1);

        render();
    }

    function check() {
        const answer = normalise(parts.input?.value);

        if (answer === '') {
            showFeedback('prompt');
            parts.input?.focus();

            return;
        }

        if (answer !== normalise(items[index].english)) {
            answered = false;
            showFeedback('wrong');
            renderNav();

            // Send them straight back to the box so a typo is one edit away.
            parts.input?.focus();
            parts.input?.select();

            return;
        }

        answered = true;

        if (parts.reveal) {
            parts.reveal.textContent = capitalise(items[index].english);
        }

        setVisible(parts.reveal, true);
        showFeedback('correct');
        renderNav();
        parts.next?.focus();
    }

    parts.prev?.addEventListener('click', () => goTo(index - 1));

    parts.next?.addEventListener('click', () => {
        if (index === total - 1) {
            window.location.assign(menuUrl);

            return;
        }

        goTo(index + 1);
    });

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        check();
    });

    render();
}

/**
 * Compare what a child typed with the word itself: case, stray spaces and a
 * stray full stop are not the thing we are testing (PRD FR-07).
 */
function normalise(value) {
    return String(value ?? '')
        .toLowerCase()
        .replace(/\s+/g, ' ')
        .replace(/[.!?,;:]+\s*$/, '')
        .trim();
}

function capitalise(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

function setVisible(element, visible) {
    element?.classList.toggle('hidden', !visible);
}
