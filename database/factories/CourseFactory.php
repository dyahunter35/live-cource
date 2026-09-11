<?php

namespace Database\Factories;

use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'دورة أساسيات البرمجة بلغة PHP',
                'ورشة إتقان أدوات التعلم الإلكتروني',
                'دورة تصميم واجهات المستخدم الحديثة',
                'برنامج مهارات العرض والتقديم المؤثر',
                'دورة تحليل البيانات باستخدام لارافيل',
            ]),
            'instructor_name' => fake()->randomElement(['أحمد الشمري', 'سارة العتيبي', 'محمد القحطاني', 'نورة السبيعي']),
            'type' => fake()->randomElement(['free', 'paid']),
            'price' => fn (array $attributes) => $attributes['type'] === 'paid' ? fake()->numberBetween(50, 500) : null,
            'status' => CourseStatus::LIVE,
            'status_label' => null,
            'next_session_title' => fake()->randomElement([
                'الجلسة الأولى: مقدمة في الدورة',
                'الجلسة الثانية: تطبيقات عملية',
                'جلسة التقييم النهائي',
            ]),
            'start_date' => fake()->randomElement(['الخميس 15 يناير', 'الاثنين 19 يناير', 'السبت 24 يناير']),
            'time_range' => fake()->randomElement(['6:00 مساءً - 8:00 مساءً', '4:00 عصراً - 6:00 مساءً']),
            'timezone' => 'بتوقيت مكة المكرمة',
        ];
    }

    public function live(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::LIVE,
            'status_label' => 'البث المباشر يبدأ الآن',
            'type' => 'free',
            'price' => null,
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::UPCOMING,
            'status_label' => 'متبقي يومان و 7 ساعات',
            'type' => 'paid',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::COMPLETED,
            'status_label' => 'انتهت الجلسات منذ يومين',
        ]);
    }

    public function notStarted(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::NOT_STARTED,
            'status_label' => 'المدة المتبقية يوم و 5 ساعات',
        ]);
    }

    public function pendingPayment(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::PENDING_PAYMENT,
            'status_label' => 'بانتظار تأكيد عملية السداد',
            'type' => 'paid',
        ]);
    }
}
