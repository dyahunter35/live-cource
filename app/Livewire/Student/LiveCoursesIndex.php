<?php

namespace App\Livewire\Student;

use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LiveCoursesIndex extends Component
{
    #[Layout('layouts.live')]
    public ?Course $selectedCourse = null;

    public bool $showModal = false;

    public string $filter = 'all';

    public function setFilter(string $filter): void
    {
        $allowed = [CourseStatus::values(), 'all'];

        $this->filter = in_array($filter, $allowed, true) ? $filter : 'all';
    }

    public function loadCourseDetails(int $courseId): void
    {
        $this->selectedCourse = Course::findOrFail($courseId);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedCourse = null;
    }

    public function render(): View
    {
        $statuses = CourseStatus::cases();

        $perStatusCounts = Course::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($total) => (int) $total);

        $counts = array_merge(
            array_fill_keys(array_map(fn (CourseStatus $status) => $status->value, $statuses), 0),
            $perStatusCounts->all(),
        );

        $filters = [
            ['key' => 'all', 'label' => 'الكل', 'count' => array_sum($counts)],
            ...array_map(
                fn (CourseStatus $status) => [
                    'key' => $status->value,
                    'label' => $status->label(),
                    'count' => $counts[$status->value],
                ],
                $statuses,
            ),
        ];

        $courses = Course::query()
            ->when($this->filter !== 'all', fn ($query) => $query->where('status', CourseStatus::from($this->filter)))
            ->orderBy('id')
            ->get();

        return view('livewire.student.live-courses-index', [
            'courses' => $courses,
            'filters' => $filters,
        ]);
    }
}
