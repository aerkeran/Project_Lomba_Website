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
     * Destination of one activity button. The lesson itself arrives in Fase 3;
     * the route exists now so navigation is complete and clickable from day one.
     */
    public function activity(int $level, string $activity): View
    {
        $this->ensureLevelExists($level);

        abort_unless(isset(self::ACTIVITIES[$activity]), 404);

        return view('activity', [
            'level' => $level,
            'activity' => $activity,
            'title' => self::ACTIVITIES[$activity]['label'],
            'icon' => self::ACTIVITIES[$activity]['icon'],
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
