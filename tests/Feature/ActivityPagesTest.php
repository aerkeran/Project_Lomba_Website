<?php

namespace Tests\Feature;

use App\Services\VocabularyRepository;
use Tests\TestCase;

/**
 * Covers the three lesson screens behind FR-04 (Materi), FR-05 (Latihan) and
 * FR-06/FR-07 (Kuis). The running of the page itself is JavaScript — see
 * resources/js/features/lesson.js — so these tests pin down everything the
 * server has to put on screen for that script to work.
 */
class ActivityPagesTest extends TestCase
{
    public function test_materi_shows_the_word_its_picture_and_a_way_to_hear_it(): void
    {
        $html = $this->get('/levels/1/materi')->assertOk()->getContent();

        // PRD §6.5 — image, English word, speaker button, next.
        $this->assertStringContainsString('/images/vocab/apple.svg', $html);
        $this->assertStringContainsString('Apple', $html);
        $this->assertStringContainsString('data-text="apple"', $html);
        $this->assertStringContainsString('data-lesson-next', $html);

        // The Indonesian half of the pairing from PRD §1.
        $this->assertStringContainsString('>apel</p>', $html);

        $this->assertStringContainsString('data-menu-url="'.route('levels.show', 1).'"', $html);
    }

    public function test_latihan_is_a_listening_drill_with_nowhere_to_type(): void
    {
        $html = $this->get('/levels/1/latihan')->assertOk()->getContent();

        $this->assertStringContainsString('Say this word:', $html);
        $this->assertStringContainsString('your turn!', $html);
        $this->assertStringContainsString('data-text="apple"', $html);

        // FR-05: no voice recognition and no typing — this screen is for repeating aloud.
        $this->assertStringNotContainsString('data-lesson-input', $html);
        $this->assertStringNotContainsString('<form', $html);
    }

    public function test_kuis_offers_audio_an_answer_box_and_both_feedbacks(): void
    {
        $html = $this->get('/levels/1/kuis')->assertOk()->getContent();

        // FR-06 — stimulus, audio, input, Check, feedback.
        $this->assertStringContainsString('/images/vocab/apple.svg', $html);
        $this->assertStringContainsString('data-text="apple"', $html);
        $this->assertStringContainsString('data-lesson-input', $html);
        $this->assertStringContainsString('for="sf-answer"', $html);
        $this->assertStringContainsString('Check</button>', $html);

        // FR-07 — both outcomes are pre-rendered so the answer arrives instantly.
        $this->assertStringContainsString('Great Job!', $html);
        $this->assertStringContainsString('Try Again!', $html);

        // A wrong answer is encouragement, never a red punishment face (DESIGN.md §19).
        $this->assertStringContainsString('bg-error-soft', $html);
        $this->assertStringNotContainsString('bg-red', $html);
    }

    public function test_the_progress_bar_counts_the_right_thing_for_each_activity(): void
    {
        $this->assertStringContainsString(
            '>Word<',
            $this->get('/levels/1/materi')->assertOk()->getContent()
        );

        $this->assertStringContainsString(
            '>Question<',
            $this->get('/levels/1/kuis')->assertOk()->getContent()
        );

        $html = $this->get('/levels/2/materi')->assertOk()->getContent();
        $expected = app(VocabularyRepository::class)->forLevel(2)->count();

        $this->assertStringContainsString(">1 / {$expected}<", $html);
    }

    public function test_every_level_hands_the_whole_lesson_to_the_page(): void
    {
        $repository = app(VocabularyRepository::class);

        foreach ($repository->availableLevels() as $level) {
            $expected = $repository->forLevel($level)->count();

            foreach (['materi', 'latihan', 'kuis'] as $activity) {
                $html = $this->get("/levels/{$level}/{$activity}")->assertOk()->getContent();

                $this->assertSame(
                    $expected,
                    substr_count($html, 'data-indonesia='),
                    "Level {$level} {$activity} is not carrying every word."
                );
            }
        }
    }

    public function test_the_picture_promise_made_by_the_data_files_really_exists(): void
    {
        $repository = app(VocabularyRepository::class);

        foreach ($repository->availableLevels() as $level) {
            foreach ($repository->forLevel($level) as $item) {
                $this->assertFileExists(
                    public_path('images/vocab/'.$item['image']),
                    "Level {$level} points at a picture that is not in public/images/vocab."
                );
            }
        }
    }
}
