<?php

use App\Livewire\Student\LiveCoursesIndex;
use App\Models\Course;
use Livewire\Livewire;

test('the live courses page renders the courses list', function () {
    Course::factory()->live()->create(['title' => 'دورة التعلم الإلكتروني']);

    $this->get(route('live-courses'))
        ->assertOk()
        ->assertSee('الدورات المباشرة')
        ->assertSee('دورة التعلم الإلكتروني')
        ->assertSee('مباشر الآن');
});

test('filtering by status shows only matching courses', function () {
    Course::factory()->live()->create(['title' => 'دورة مباشرة الآن']);
    Course::factory()->upcoming()->create(['title' => 'دورة قادمة قريباً']);

    Livewire::test(LiveCoursesIndex::class)
        ->call('setFilter', 'upcoming')
        ->assertSet('filter', 'upcoming')
        ->assertSee('دورة قادمة قريباً')
        ->assertDontSee('دورة مباشرة الآن');
});

test('setFilter ignores unknown filter values', function () {
    Livewire::test(LiveCoursesIndex::class)
        ->call('setFilter', 'hacked')
        ->assertSet('filter', 'all');
});

test('the modal opens with the selected course details', function () {
    $course = Course::factory()->live()->create(['title' => 'دورة اختبار الواجهة']);

    Livewire::test(LiveCoursesIndex::class)
        ->call('loadCourseDetails', $course->id)
        ->assertSet('showModal', true)
        ->assertSet('selectedCourse.id', $course->id)
        ->assertSee('دورة اختبار الواجهة');
});

test('the modal can be closed', function () {
    $course = Course::factory()->live()->create();

    Livewire::test(LiveCoursesIndex::class)
        ->call('loadCourseDetails', $course->id)
        ->call('closeModal')
        ->assertSet('showModal', false)
        ->assertSet('selectedCourse', null);
});
