<?php

namespace App\Http\Controllers;

use App\Services\VocabularyRepository;
use Illuminate\View\View;

/**
 * The navigation shell of a level (PRD §6.3–§6.4): the level picker, the
 * learning menu, and the entry points to Materi / Latihan / Kuis.
 */
class LevelController extends Controller
{
    /**
     * The three things a child can do with a level (PRD §6.4).
     *
     * @var array<string, array{icon: string, label: string}>
     */
    private const ACTIVITIES = [
        'materi' => ['icon' => '📚', 'label' => 'Materi'],
        'latihan' => ['icon' => '🗣️', 'label' => 'Latihan'],
        'kuis' => ['icon' => '📝', 'label' => 'Kuis / Tes'],
    ];

    public function __construct(private readonly VocabularyRepository $vocabulary) {}

    /**
     * Level selection — one button per class (PRD §6.3).
     */
    public function index(): View
    {
        return view('levels', [
            'levels' => $this->vocabulary->availableLevels(),
        ]);
    }

    /**
     * Learning menu of a single level (PRD §6.4).
     */
    public function show(int $level): View
    {
        $this->ensureLevelExists($level);

        return view('learning-menu', [
            'level' => $level,
            'activities' => self::ACTIVITIES,
        ]);
    }

    /**
     * One of the three activities of a level (PRD §6.5–§6.7). The whole level
     * is handed to the view so the child can move between words without
     * waiting for a page to reload between every one.
     */
    public function activity(int $level, string $activity): View
    {
        $this->ensureLevelExists($level);

        abort_unless(isset(self::ACTIVITIES[$activity]), 404);

        $items = $this->vocabulary->forLevel($level);

        return view('activities.'.$activity, [
            'level' => $level,
            'activity' => $activity,
            'label' => self::ACTIVITIES[$activity]['label'],
            'icon' => self::ACTIVITIES[$activity]['icon'],
            'items' => $items,
            'total' => $items->count(),
            'menuUrl' => route('levels.show', $level),
        ]);
    }

    /**
     * An unknown class must not show an empty level (DESIGN.md §27).
     */
    private function ensureLevelExists(int $level): void
    {
        abort_unless($this->vocabulary->forLevel($level)->isNotEmpty(), 404);
    }
}
