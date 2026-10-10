<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class BladeComponentsTest extends TestCase
{
    public function test_the_audio_button_exposes_every_state_the_design_requires(): void
    {
        $html = Blade::render('<x-audio-button text="apple" label="Listen" />');

        $this->assertStringContainsString('data-audio-button', $html);
        $this->assertStringContainsString('data-text="apple"', $html);
        $this->assertStringContainsString('data-state="idle"', $html);
        $this->assertStringContainsString('data-label-idle="Listen"', $html);
        $this->assertStringContainsString('data-label-speaking="Speaking..."', $html);
        $this->assertStringContainsString('data-label-done="Listen Again"', $html);
        $this->assertStringContainsString('sf-audio-button__label', $html);
        $this->assertStringContainsString('aria-live="polite"', $html);
    }

    public function test_buttons_use_the_shared_button_system_so_touch_targets_stay_large(): void
    {
        $this->assertStringContainsString('btn btn--primary btn--md', Blade::render('<x-button>Play</x-button>'));
        $this->assertStringContainsString('btn btn--secondary btn--lg', Blade::render('<x-button variant="secondary" size="lg">Play</x-button>'));
        // sm is the smallest size offered, and the .btn--sm rule keeps it at 44px.
        $this->assertStringContainsString('btn btn--primary btn--sm', Blade::render('<x-button size="sm">Play</x-button>'));
    }

    public function test_a_link_button_renders_an_anchor_instead_of_a_button(): void
    {
        $html = Blade::render('<x-button href="/levels">Choose</x-button>');

        $this->assertStringContainsString('<a', $html);
        $this->assertStringContainsString('href="/levels"', $html);
        $this->assertStringNotContainsString('<button', $html);
    }

    public function test_a_wrong_answer_is_offered_as_encouragement_not_punishment(): void
    {
        $html = Blade::render('<x-feedback state="error" title="Try Again!" message="You can do it!" />');

        $this->assertStringContainsString('role="alert"', $html);
        $this->assertStringContainsString('Try Again!', $html);
        $this->assertStringContainsString('You can do it!', $html);
        $this->assertStringContainsString('bg-error-soft', $html);
        $this->assertStringNotContainsString('bg-red', $html);
    }

    public function test_the_card_gives_children_a_clear_container(): void
    {
        $html = Blade::render('<x-card padding="lg">Content</x-card>');

        $this->assertStringContainsString('rounded-card', $html);
        $this->assertStringContainsString('bg-surface', $html);
        $this->assertStringContainsString('p-6 sm:p-8', $html);
        $this->assertStringContainsString('Content', $html);
    }

    public function test_the_progress_bar_describes_itself_to_screen_readers(): void
    {
        $html = Blade::render('<x-progress-bar :value="3" :max="10" label="Question" />');

        $this->assertStringContainsString('role="progressbar"', $html);
        $this->assertStringContainsString('aria-valuenow="3"', $html);
        $this->assertStringContainsString('aria-valuemax="10"', $html);
        $this->assertStringContainsString('3 / 10', $html);
    }

    public function test_the_back_button_is_a_clearly_labelled_link(): void
    {
        $html = Blade::render('<x-back-button href="/levels" label="Back" />');

        $this->assertStringContainsString('href="/levels"', $html);
        $this->assertStringContainsString('min-h-11', $html);
        $this->assertStringContainsString('←', $html);
    }

    public function test_the_layout_points_at_the_tts_route_and_announces_audio_problems(): void
    {
        if (! file_exists(public_path('build/manifest.json'))) {
            $this->markTestSkipped('Front-end build is missing; run npm run build.');
        }

        $html = view('layouts.app')->render();

        $this->assertStringContainsString('data-tts-url="'.route('tts').'"', $html);
        $this->assertStringContainsString('id="sf-tts-status"', $html);
        $this->assertStringContainsString('aria-live="polite"', $html);
    }
}
