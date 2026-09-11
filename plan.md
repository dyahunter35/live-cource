# خطة تنفيذ مشروع صفحة الدورات المباشرة والنوافذ المنبثقة (Live Courses & Modal Popup) باستخدام Laravel و Tailwind CSS v4

هذه الخطة مصممة خصيصاً لتوجيه أداة التطوير الذكي (مثل **OpenCode** أو أي مساعد برمجي) لتنفيذ واجهة "منصة منيسوتا للتدريب والتطوير" بكفاءة عالية، مع الالتزام التام بالمتطلبات البصرية والتفاعلية الموجودة في التصاميم المرفقة (جدول الدورات + نافذة الـ Popup).

---

## 1. المتطلبات التقنية والبيئة (Tech Stack)
* **Backend**: Laravel 11+
* **Reactive Layer**: Livewire v3 (أو Alpine.js مع Blade) لضمان عدم إعادة تحميل الصفحة عند الضغط على زر "التفاصيل".
* **Styling**: Tailwind CSS v4 (مع استخدام الألوان، المسافات، والانحناءات `rounded-2xl` المطابقة تماماً لصور التصميم).
* **Icons**: Blade Icons / Heroicons (لأيقونات الجدول والـ Popup مثل التقويم، الساعة، الوثائق، والواتساب).

---

## 2. هيكلة قاعدة البيانات (Database Schema)

تأكد من وجود الجداول والعلاقات التالية:

### جدول `courses` (الدورات)
* `id` (Primary Key)
* `title` (string) - عنوان الدورة (مثل: التهيئة التقنية، تحليل البيانات الوصفي)
* `slug` (string)
* `instructor_name` (string) - اسم المدرب (مثل: د. أحمد السالم)
* `type` (string) - نوع الدورة (`free` أو `paid`)
* `price` (decimal, nullable) - سعر الدورة (مثل: 25 دولار)
* `status` (string) - حالة الدورة (`live` مباشر الآن، `upcoming` قادمة، `pending_payment` بانتظار السداد، `completed` مكتملة، `not_started` لم تبدأ بعد)
* `status_label` (string) - النص التفصيلي للحالة (مثل: الجلسة قائمة حالياً، متبقي 1 يوم و 11 ساعة)
* `image` (string, nullable) - مسار الصورة الترويجية
* `next_session_title` (string) - عنوان الجلسة القادمة (مثل: الجلسة الأولى: مدخل إلى التقنيات الحديثة)
* `start_date` (date) - تاريخ الدورة (مثل: السبت 05 سبتمبر 2026)
* `time_range` (string) - الوقت (مثل: 09:00 ص - 10:00 ص)
* `timezone` (string) - التوقيت (مثل: بتوقيت مكة المكرمة)
* `material_pdf` (string, nullable) - رابط ملف المادة العلمية PDF
* `whatsapp_link` (string, nullable) - رابط التواصل عبر واتساب
* `timestamps`

---

## 3. خطوات التنفيذ البرمجي (Step-by-Step Implementation)

### الخطوة الأولى: إنشاء مكون Livewire (Backend Controller & State)
قم بتنفيذ الأمر التالي لإنشاء مكون Livewire لإدارة الصفحة:
```bash
php artisan make:livewire Student/LiveCoursesIndex
```

**ملف الكلاس `app/Http/Livewire/Student/LiveCoursesIndex.php`:**
```php
namespace App\Http\Livewire\Student;

use Livewire\Component;
use App\Models\Course;

class LiveCoursesIndex extends Component
{
    public $selectedCourse = null;
    public $showModal = false;
    public $filter = 'all';

    public function loadCourseDetails($courseId)
    {
        $this->selectedCourse = Course::find($courseId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCourse = null;
    }

    public function setFilter($filterType)
    {
        $this->filter = $filterType;
    }

    public function render()
    {
        $query = Course::query();
        
        if ($this->filter === 'upcoming') {
            $query->where('status', 'upcoming');
        } elseif ($this->filter === 'live') {
            $query->where('status', 'live');
        } elseif ($this->filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($this->filter === 'not_started') {
            $query->where('status', 'not_started');
        }

        $courses = $query->get();
        $counts = [
            'all' => Course::count(),
            'upcoming' => Course::where('status', 'upcoming')->count(),
            'live' => Course::where('status', 'live')->count(),
            'completed' => Course::where('status', 'completed')->count(),
            'not_started' => Course::where('status', 'not_started')->count(),
        ];

        return view('livewire.student.live-courses-index', compact('courses', 'counts'));
    }
}
```

---

### الخطوة الثانية: تصميم صفحة الدورات المباشرة (Table View & Filters)
**ملف الواجهة `resources/views/livewire/student/live-courses-index.blade.php`:**

```html
<div class="p-6 bg-gray-50/50 min-h-screen font-sans text-right" dir="rtl">
    
    <!-- ترويسة الصفحة وعدادات الفلترة العلويّة -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">الدورات المباشرة</h1>
            <p class="text-sm text-gray-500 mt-1">تابع دوراتك وجدول جلساتها بكل سهولة</p>
        </div>

        <!-- أزرار الفلترة الأفقية -->
        <div class="flex flex-wrap items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100">
            <button wire:click="setFilter('all')" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $filter === 'all' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                الكل ({{ $counts['all'] }})
            </button>
            <button wire:click="setFilter('upcoming')" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $filter === 'upcoming' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                القادمة ({{ $counts['upcoming'] }})
            </button>
            <button wire:click="setFilter('live')" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $filter === 'live' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                المباشرة الآن ({{ $counts['live'] }})
            </button>
            <button wire:click="setFilter('completed')" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $filter === 'completed' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                المكتملة ({{ $counts['completed'] }})
            </button>
            <button wire:click="setFilter('not_started')" class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $filter === 'not_started' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                لم تبدأ بعد ({{ $counts['not_started'] }})
            </button>
        </div>
    </div>

    <!-- جدول الدورات -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs font-semibold bg-gray-50/50">
                        <th class="p-4">الدورة</th>
                        <th class="p-4">الجلسة القادمة</th>
                        <th class="p-4">التاريخ والوقت</th>
                        <th class="p-4">حالة الدورة</th>
                        <th class="p-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($courses as $course)
                    <tr class="hover:bg-blue-50/20 transition-colors">
                        <!-- عمود الدورة -->
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                                    🎓
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        @if($course->price) مدفوعة - {{ $course->price }} دولار @else دورة حية مجانية @endif | د. {{ $course->instructor_name }}
                                    </div>
                                    <button wire:click="loadCourseDetails({{ $course->id }})" class="text-blue-600 hover:text-blue-700 text-xs font-medium inline-flex items-center gap-1 mt-1 cursor-pointer">
                                        <span>التفاصيل</span> ℹ️
                                    </button>
                                </div>
                            </div>
                        </td>

                        <!-- الجلسة القادمة -->
                        <td class="p-4">
                            <div class="font-medium text-gray-800">{{ $course->next_session_title }}</div>
                        </td>

                        <!-- التاريخ والوقت -->
                        <td class="p-4 text-gray-600">
                            <div class="flex items-center gap-2">
                                📅 <span>{{ $course->start_date }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">
                                ⏰ <span>{{ $course->time_range }}</span> | <span>{{ $course->timezone }}</span>
                            </div>
                        </td>

                        <!-- حالة الدورة -->
                        <td class="p-4">
                            @if($course->status === 'live')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> مباشر الآن
                                </span>
                                <div class="text-[11px] text-gray-400 mt-1">الجلسة قائمة حالياً</div>
                            @elseif($course->status === 'upcoming')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                    🕒 قادمة
                                </span>
                                <div class="text-[11px] text-gray-400 mt-1">{{ $course->status_label }}</div>
                            @elseif($course->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600 border border-green-100">
                                    ✅ مكتملة
                                </span>
                                <div class="text-[11px] text-gray-400 mt-1">تم الحضور</div>
                            @elseif($course->status === 'not_started')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-600 border border-orange-100">
                                    ⏳ لم تبدأ بعد
                                </span>
                                <div class="text-[11px] text-gray-400 mt-1">{{ $course->status_label }}</div>
                            @endif
                        </td>

                        <!-- الإجراءات -->
                        <td class="p-4 text-center">
                            @if($course->status === 'live')
                                <a href="#" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                    انضم الآن 🎥
                                </a>
                            @elseif($course->status === 'completed')
                                <a href="#" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-medium transition">
                                    مشاهدة التسجيل
                                </a>
                            @else
                                <span class="text-gray-300 font-bold">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">لا توجد دورات متاحة حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- نافذة الـ Popup المنبثقة (Modal) المطابقة لتصميم popup.jpeg -->
    @if($showModal && $selectedCourse)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto animate-fade-in" wire:click.self="closeModal">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden relative border border-gray-100 my-8">
            
            <!-- زر الإغلاق العلوي -->
            <button wire:click="closeModal" class="absolute top-5 left-5 w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition cursor-pointer z-10">
                ✕
            </button>

            <div class="p-6 md:p-8 space-y-6 max-h-[85vh] overflow-y-auto">
                
                <!-- رأس الـ Popup (العنوان، الشعار، الصورة المصغرة) -->
                <div class="flex flex-col md:flex-row justify-between items-start gap-4 pb-6 border-b border-gray-100">
                    <div class="space-y-2 flex-1">
                        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-medium rounded-full">
                            {{ $selectedCourse->price ? 'دورة تدريبية مدفوعة' : 'دورة حية مجانية' }}
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $selectedCourse->title }}</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">دورة تعريفية تهتم بتهيئة المشاركين لاستخدام أدوات ومنصات التعلم الإلكتروني بكفاءة عالية.</p>
                    </div>
                    <div class="w-full md:w-36 h-24 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-800 flex items-center justify-center text-white text-xs font-bold shadow-md shrink-0 overflow-hidden">
                        🖼️ معاينة الدورة
                    </div>
                </div>

                <!-- شبكة التفاصيل (Grid Cards) المطابقة تماماً لـ popup.jpeg -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- المدرب -->
                    <div class="p-4 bg-blue-50/40 rounded-2xl border border-blue-100/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">المدرب</span>
                            <span class="font-bold text-gray-800 text-sm">د. {{ $selectedCourse->instructor_name }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                            👨‍🏫
                        </div>
                    </div>

                    <!-- نوع الدورة -->
                    <div class="p-4 bg-emerald-50/40 rounded-2xl border border-emerald-100/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">نوع الدورة</span>
                            <span class="font-bold text-gray-800 text-sm">{{ $selectedCourse->price ? $selectedCourse->price . ' دولار' : 'مجانية بالكامل' }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                            🏷️
                        </div>
                    </div>

                    <!-- التاريخ والوقت -->
                    <div class="p-4 bg-purple-50/30 rounded-2xl border border-purple-100/50 col-span-1 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">التاريخ والوقت</span>
                            <span class="font-bold text-gray-800 text-sm block">{{ $selectedCourse->start_date }} | {{ $selectedCourse->time_range }}</span>
                            <span class="text-[11px] text-gray-400 mt-0.5 block">{{ $selectedCourse->timezone }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg shrink-0">
                            📅
                        </div>
                    </div>

                    <!-- عدد جلسات الدورة -->
                    <div class="p-4 bg-amber-50/40 rounded-2xl border border-amber-100/60 col-span-1 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">عدد جلسات الدورة</span>
                            <span class="font-bold text-gray-800 text-sm">3 جلسات تفاعلية</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                            🎥
                        </div>
                    </div>

                    <!-- حالة الدورة -->
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 col-span-1 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">حالة الدورة</span>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-lg">قادمة</span>
                                <span class="text-xs text-gray-600 font-medium">متبقي 9 ساعات و 16 دقيقة</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gray-200 text-gray-600 flex items-center justify-center text-lg">
                            ⏳
                        </div>
                    </div>

                </div>

                <!-- أزرار الإجراء السفلية داخل الـ Popup -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-gray-100">
                    <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition">
                        📄 المادة العلمية (PDF)
                    </a>
                    
                    <a href="https://wa.me/" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-between gap-3 px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-bold transition">
                        <div class="flex items-center gap-2">
                            <span>💬</span>
                            <span>تواصل معنا عبر واتساب</span>
                        </div>
                        <span>←</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>
```

---

## 4. إعداد التوجيه (Routes)
في ملف `routes/web.php`:
```php
use App\Http\Livewire\Student\LiveCoursesIndex;

Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('/live-courses', LiveCoursesIndex::class)->name('student.live-courses');
});
```

---

## 5. تعليمات التنفيذ لـ OpenCode
1. تأكد من إعداد قاعدة البيانات وتطبيق الجداول عبر `php artisan migrate`.
2. قم بتثبيت حزم الـ Icons المطلوبة أو استخدم رموز تعبيرية (Emojis) كما هو موضح في الخطة مؤقتاً لحين ربط مكتبة Heroicons.
3. تأكد من تفعيل دعم **Tailwind CSS v4** في مشروع Laravel عبر الـ Vite asset pipeline.
4. اختبر تفاعل زر "التفاصيل" لضمان ظهور الـ Popup بانسيابية تامة دون أي إعادة تحميل للصفحة (AJAX Real-time update).
