<?php

namespace App\Services;

use Illuminate\Support\Collection;
use RuntimeException;

/**
 * Reads the static vocabulary content from database/data, one JSON file per level.
 *
 * The workshop has no student accounts and no vocabulary tables, so these files
 * are the single source of truth (PRD §7). A malformed file is a content/programming
 * mistake rather than something a child can trigger, therefore it fails loudly.
 */
class VocabularyRepository
{
    /**
     * Keys every item must carry (PRD §7).
     *
     * @var list<string>
     */
    public const REQUIRED_KEYS = ['id', 'level', 'indonesia', 'english', 'image', 'audio'];

    /**
     * Parsed levels, keyed by level number, so a level file is read at most once.
     *
     * @var array<int, Collection<int, array{id: int, level: int, indonesia: string, english: string, image: string, audio: string}>>
     */
    private array $levels = [];

    private readonly string $dataPath;

    public function __construct(?string $dataPath = null)
    {
        $this->dataPath = $dataPath ?? database_path('data');
    }

    /**
     * Levels that have a data file, ascending. Used to build the level picker.
     *
     * @return array<int, int>
     */
    public function availableLevels(): array
    {
        $levels = [];

        foreach (glob($this->dataPath.'/level-*.json') ?: [] as $file) {
            if (preg_match('/level-(\d+)\.json$/', $file, $matches) === 1) {
                $levels[] = (int) $matches[1];
            }
        }

        sort($levels);

        return $levels;
    }

    /**
     * The ordered items of a level. Returns an empty collection when the level
     * has no data file, so callers can render an empty state (DESIGN.md §26).
     *
     * @return Collection<int, array{id: int, level: int, indonesia: string, english: string, image: string, audio: string}>
     */
    public function forLevel(int $level): Collection
    {
        if ($level < 1) {
            return collect();
        }

        if (! isset($this->levels[$level])) {
            $this->levels[$level] = $this->read($level);
        }

        return $this->levels[$level];
    }

    /**
     * A single item of a level, or null when neither the level nor the item exists.
     *
     * @return array{id: int, level: int, indonesia: string, english: string, image: string, audio: string}|null
     */
    public function find(int $level, int $id): ?array
    {
        return $this->forLevel($level)->firstWhere('id', $id);
    }

    /**
     * @return Collection<int, array{id: int, level: int, indonesia: string, english: string, image: string, audio: string}>
     */
    private function read(int $level): Collection
    {
        $path = $this->dataPath.'/level-'.$level.'.json';

        if (! is_file($path)) {
            return collect();
        }

        $decoded = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        if (! is_array($decoded) || ! is_array($decoded['items'] ?? null)) {
            throw new RuntimeException("Vocabulary file [{$path}] must contain an \"items\" array.");
        }

        $items = [];

        foreach ($decoded['items'] as $index => $item) {
            if (! is_array($item) || array_diff(self::REQUIRED_KEYS, array_keys($item)) !== []) {
                throw new RuntimeException(
                    "Item {$index} of [{$path}] must contain: ".implode(', ', self::REQUIRED_KEYS).'.'
                );
            }

            $items[] = $item;
        }

        return collect($items);
    }
}
