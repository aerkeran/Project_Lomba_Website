<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TtsRouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Keeps the MP3 cache out of the real tts-cache folder.
        config(['tts.cache_path' => 'framework/testing/tts-cache']);
    }

    protected function tearDown(): void
    {
        Storage::disk('local')->deleteDirectory('framework/testing/tts-cache');

        parent::tearDown();
    }

    public function test_it_serves_an_mp3_when_the_provider_answers(): void
    {
        config(['tts.voicerss.key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake(['api.voicerss.org/*' => Http::response($this->fakeMp3(), 200, ['Content-Type' => 'audio/mpeg'])]);

        $response = $this->getJson('/tts?text=apple');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'audio/mpeg');
        Http::assertSent(fn (Request $request): bool => $request['key'] === 'test-key' && $request['src'] === 'apple');
    }

    public function test_a_repeated_word_is_served_from_the_cache_so_the_quota_is_spent_once(): void
    {
        config(['tts.voicerss.key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake(['api.voicerss.org/*' => Http::response($this->fakeMp3())]);

        $this->getJson('/tts?text=apple')->assertOk();
        $this->getJson('/tts?text=apple')->assertOk();

        Http::assertSentCount(1);
    }

    public function test_it_falls_back_when_the_provider_rejects_the_request(): void
    {
        config(['tts.voicerss.key' => 'rejected']);
        Http::preventStrayRequests();
        Http::fake(['api.voicerss.org/*' => Http::response('The key is invalid.', 400)]);

        $this->getJson('/tts?text=apple')->assertStatus(503);
    }

    public function test_it_answers_503_instead_of_leaking_details_when_no_key_is_configured(): void
    {
        config(['tts.voicerss.key' => null]);
        Http::preventStrayRequests();

        $this->getJson('/tts?text=apple')
            ->assertStatus(503)
            ->assertJson(['message' => 'Audio is not available right now.']);
    }

    public function test_the_key_never_reaches_the_client(): void
    {
        config(['tts.voicerss.key' => 'super-secret']);
        Http::preventStrayRequests();
        Http::fake(['api.voicerss.org/*' => Http::response('The key is invalid.', 400)]);

        $this->getJson('/tts?text=apple')
            ->assertStatus(503)
            ->assertDontSee('super-secret');
    }

    public function test_unexpected_input_is_rejected_before_it_reaches_the_provider(): void
    {
        config(['tts.voicerss.key' => 'test-key']);
        Http::preventStrayRequests();

        $this->getJson('/tts?text=<script>alert(1)</script>')->assertStatus(422);

        Http::assertNothingSent();
    }

    private function fakeMp3(): string
    {
        // Real MP3s start with an ID3 tag; the service checks for it before caching.
        return 'ID3'.str_repeat("\0", 128);
    }
}
