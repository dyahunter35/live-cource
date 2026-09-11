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

test('searching by title shows only matching courses', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل متقدمة']);
    Course::factory()->live()->create(['title' => 'دورة تصميم واجهات']);

    Livewire::test(LiveCoursesIndex::class)
        ->set('search', 'لارافيل')
        ->assertSee('دورة لارافيل متقدمة')
        ->assertDontSee('دورة تصميم واجهات');
});

test('searching by instructor name shows only their courses', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل', 'instructor_name' => 'أحمد الشمري']);
    Course::factory()->live()->create(['title' => 'دورة فلو', 'instructor_name' => 'سارة العتيبي']);

    Livewire::test(LiveCoursesIndex::class)
        ->set('search', 'أحمد الشمري')
        ->assertSee('دورة لارافيل')
        ->assertDontSee('دورة فلو');
});

test('searching by next session title shows only matching courses', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل', 'next_session_title' => 'الجلسة الأولى: مقدمة في الدورة']);
    Course::factory()->live()->create(['title' => 'دورة فلو', 'next_session_title' => 'جلسة التقييم النهائي']);

    Livewire::test(LiveCoursesIndex::class)
        ->set('search', 'مقدمة في الدورة')
        ->assertSee('دورة لارافيل')
        ->assertDontSee('دورة فلو');
});

test('search dispatches the search event from the header', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل متقدمة']);
    Course::factory()->live()->create(['title' => 'دورة تصميم واجهات']);

    Livewire::test(LiveCoursesIndex::class)
        ->dispatch('search', value: 'لارافيل')
        ->assertSee('دورة لارافيل متقدمة')
        ->assertDontSee('دورة تصميم واجهات');
});

test('clearing the search restores all courses', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل متقدمة']);
    Course::factory()->upcoming()->create(['title' => 'دورة تصميم واجهات']);

    Livewire::test(LiveCoursesIndex::class)
        ->set('search', 'لارافيل')
        ->assertDontSee('دورة تصميم واجهات')
        ->set('search', '')
        ->assertSee('دورة لارافيل متقدمة')
        ->assertSee('دورة تصميم واجهات');
});

test('search and status filter can be combined', function () {
    Course::factory()->live()->create(['title' => 'دورة لارافيل المباشرة']);
    Course::factory()->upcoming()->create(['title' => 'دورة لارافيل القادمة']);

    Livewire::test(LiveCoursesIndex::class)
        ->set('search', 'لارافيل')
        ->call('setFilter', 'live')
        ->assertSet('filter', 'live')
        ->assertSee('دورة لارافيل المباشرة')
        ->assertDontSee('دورة لارافيل القادمة');
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
