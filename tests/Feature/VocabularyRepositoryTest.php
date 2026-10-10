<?php

namespace Tests\Feature;

use App\Services\VocabularyRepository;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Tests\TestCase;

class VocabularyRepositoryTest extends TestCase
{
    private string $brokenDataPath = '';

    protected function tearDown(): void
    {
        if ($this->brokenDataPath !== '') {
            File::deleteDirectory($this->brokenDataPath);
        }

        parent::tearDown();
    }

    public function test_it_lists_every_level_that_has_a_data_file(): void
    {
        $this->assertSame([1, 2, 3, 4, 5, 6], app(VocabularyRepository::class)->availableLevels());
    }

    public function test_it_returns_the_vocabulary_of_a_level(): void
    {
        $items = app(VocabularyRepository::class)->forLevel(1);

        $this->assertCount(8, $items);
        $this->assertSame('apple', $items->first()['english']);
        $this->assertSame('apel', $items->first()['indonesia']);
    }

    public function test_every_level_carries_the_item_fields_required_by_the_prd(): void
    {
        $repository = app(VocabularyRepository::class);

        foreach ($repository->availableLevels() as $level) {
            $items = $repository->forLevel($level);

            $this->assertCount(8, $items, "Level {$level} should hold eight words.");

            foreach ($items as $item) {
                $missing = array_diff(VocabularyRepository::REQUIRED_KEYS, array_keys($item));

                $this->assertSame([], $missing, "Item {$item['id']} of level {$level} is missing: ".implode(', ', $missing));
                $this->assertSame($level, $item['level']);
            }
        }
    }

    public function test_every_item_points_at_an_image_that_exists(): void
    {
        $repository = app(VocabularyRepository::class);

        foreach ($repository->availableLevels() as $level) {
            foreach ($repository->forLevel($level) as $item) {
                $this->assertFileExists(
                    public_path('images/vocab/'.$item['image']),
                    "Level {$level} item {$item['id']} has no artwork yet."
                );
            }
        }
    }

    public function test_a_level_without_a_data_file_is_empty_so_a_page_can_show_an_empty_state(): void
    {
        $repository = app(VocabularyRepository::class);

        $this->assertCount(0, $repository->forLevel(99));
        $this->assertCount(0, $repository->forLevel(0));
    }

    public function test_it_finds_a_single_item_and_returns_null_for_an_unknown_one(): void
    {
        $repository = app(VocabularyRepository::class);

        $this->assertSame('cat', $repository->find(1, 3)['english']);
        $this->assertNull($repository->find(1, 999));
        $this->assertNull($repository->find(99, 1));
    }

    public function test_an_incomplete_item_fails_loudly_instead_of_breaking_a_lesson_later(): void
    {
        $this->brokenDataPath = storage_path('framework/testing/vocabulary-'.uniqid());
        File::makeDirectory($this->brokenDataPath, 0755, true);
        File::put($this->brokenDataPath.'/level-1.json', json_encode([
            'level' => 1,
            'items' => [['id' => 1, 'english' => 'apple']],
        ]));

        $repository = new VocabularyRepository($this->brokenDataPath);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/must contain: id, level, indonesia, english, image, audio/');

        $repository->forLevel(1);
    }
}
