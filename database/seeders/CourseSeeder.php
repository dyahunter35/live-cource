<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory()->live()->create([
            'title' => 'دورة التعلم الإلكتروني التفاعلي',
            'instructor_name' => 'د. أحمد الشمري',
            'next_session_title' => 'الجلسة الثالثة: أدوات التقييم التفاعلي',
        ]);

        Course::factory()->live()->create([
            'title' => 'ورشة إتقان أدوات منصات التعلم',
            'instructor_name' => 'م. سارة العتيبي',
            'next_session_title' => 'الجلسة الأولى: مقدمة في المنصة',
        ]);

        Course::factory()->upcoming()->create([
            'title' => 'دورة بناء الدورات التدريبية الاحترافية',
            'instructor_name' => 'د. محمد القحطاني',
            'price' => 299,
            'next_session_title' => 'الجلسة الأولى: خطوات الإعداد والتخطيط',
        ]);

        Course::factory()->upcoming()->create([
            'title' => 'برنامج إعداد المدربين المعتمد',
            'instructor_name' => 'أ. نورة السبيعي',
            'price' => 189,
            'next_session_title' => 'التعريف بالبرنامج ومنهجية التدريب',
        ]);

        Course::factory()->notStarted()->create([
            'title' => 'دورة أساسيات تصميم العروض التقديمية',
            'instructor_name' => 'د. أحمد الشمري',
            'price' => 99,
        ]);

        Course::factory()->pendingPayment()->create([
            'title' => 'دورة مهارات التواصل الفعال',
            'instructor_name' => 'م. سارة العتيبي',
            'price' => 149,
        ]);

        Course::factory()->completed()->create([
            'title' => 'دورة مقدمة في البرمجة بلغة PHP',
            'instructor_name' => 'د. محمد القحطاني',
            'price' => 249,
        ]);

        Course::factory()->completed()->create([
            'title' => 'ورشة بناء الصفحات بتقنية لارافيل',
            'instructor_name' => 'أ. نورة السبيعي',
        ]);
    }
}
