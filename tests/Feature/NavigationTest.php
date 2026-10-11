<?php

namespace Tests\Feature;

use Tests\TestCase;

class NavigationTest extends TestCase
{
    public function test_the_start_screen_offers_play_settings_and_volume(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('SpeakFun!', $html);
        $this->assertStringContainsString('Listen, Speak, Learn!', $html);
        $this->assertStringContainsString('data-volume-slider', $html);
        $this->assertContains('/levels', $this->linkPaths($html), 'The start screen needs a Play button.');
        $this->assertContains('/settings', $this->linkPaths($html), 'The start screen needs a Settings button.');
    }

    public function test_the_settings_screen_only_offers_volume(): void
    {
        $html = $this->get('/settings')->assertOk()->getContent();

        // PRD §6.2 — volume is deliberately the only setting.
        $this->assertSame(1, substr_count($html, '<input'), 'Settings must expose exactly one control.');
        $this->assertStringContainsString('data-volume-slider', $html);
        $this->assertContains('/', $this->linkPaths($html), 'Settings needs a way back to the start screen.');
    }

    public function test_the_level_picker_lists_every_level_with_a_way_back(): void
    {
        $html = $this->get('/levels')->assertOk()->getContent();

        foreach (range(1, 6) as $level) {
            $this->assertContains("/levels/{$level}", $this->linkPaths($html), "Level {$level} is missing.");
            $this->assertStringContainsString("Level {$level}", $html);
        }

        $this->assertContains('/', $this->linkPaths($html));
    }

    public function test_the_learning_menu_offers_the_three_activities_of_a_level(): void
    {
        $html = $this->get('/levels/1')->assertOk()->getContent();

        foreach (['materi', 'latihan', 'kuis'] as $activity) {
            $this->assertContains(
                "/levels/1/{$activity}",
                $this->linkPaths($html),
                "The {$activity} button is missing."
            );
        }

        $this->assertStringContainsString('Materi', $html);
        $this->assertStringContainsString('Latihan', $html);
        $this->assertStringContainsString('Kuis / Tes', $html);
        $this->assertContains('/levels', $this->linkPaths($html), 'The learning menu needs a way back.');
    }

    public function test_every_activity_is_reachable_and_points_back_to_its_level(): void
    {
        foreach (['materi', 'latihan', 'kuis'] as $activity) {
            $html = $this->get("/levels/1/{$activity}")->assertOk()->getContent();

            $this->assertStringContainsString('No lessons yet.', $html);
            $this->assertContains('/levels/1', $this->linkPaths($html), "Back button missing on {$activity}.");
        }
    }

    public function test_an_unknown_level_or_activity_is_not_found(): void
    {
        $this->get('/levels/99')->assertNotFound();
        $this->get('/levels/99/materi')->assertNotFound();
        $this->get('/levels/1/tantangan')->assertNotFound();
        $this->get('/levels/abc')->assertNotFound();
    }

    /**
     * Every link on the page, reduced to its path so the assertion does not
     * depend on the host name the test request happens to use.
     *
     * @return array<int, string|null>
     */
    private function linkPaths(string $html): array
    {
        preg_match_all('/href="([^"]*)"/', $html, $matches);

        $paths = [];

        foreach ($matches[1] as $href) {
            $path = parse_url($href, PHP_URL_PATH);

            // The root URL is generated as "http://host" with no path at all.
            $paths[] = preg_match('#^https?://#', $href) === 1 ? ($path ?: '/') : $path;
        }

        return array_values(array_unique($paths));
    }
}
