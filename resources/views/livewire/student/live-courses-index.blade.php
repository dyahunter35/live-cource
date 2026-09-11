<div class="p-6 bg-gray-50/50 min-h-screen font-sans text-gray-900">
    <!-- الترويسة وأزرار التصفية -->
    <div class="max-w-6xl mx-auto mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">الدورات المباشرة</h1>
            <p class="text-sm text-gray-500 mt-1">تابع دوراتك وجدول جلساتها بكل سهولة</p>
        </div>

        <div class="flex flex-wrap items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100">
            @foreach ($filters as $filterOption)
                <button
                    wire:click="setFilter('{{ $filterOption['key'] }}')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition cursor-pointer {{ $filter === $filterOption['key'] ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}"
                >
                    {{ $filterOption['label'] }} ({{ $filterOption['count'] }})
                </button>
            @endforeach
        </div>
    </div>

    <!-- جدول الدورات -->
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
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
                    <tr wire:key="course-{{ $course->id }}" class="hover:bg-blue-50/20 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">🎓</div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        @if ($course->price)
                                            مدفوعة - {{ $course->price }} دولار
                                        @else
                                            دورة حية مجانية
                                        @endif
                                        | د. {{ $course->instructor_name }}
                                    </div>
                                    <button wire:click="loadCourseDetails({{ $course->id }})" class="text-blue-600 hover:text-blue-700 text-xs font-medium inline-flex items-center gap-1 mt-1 cursor-pointer">
                                        <span>التفاصيل</span> ℹ️
                                    </button>
                                </div>
                            </div>
                        </td>

                        <td class="p-4 font-medium text-gray-800">{{ $course->next_session_title }}</td>

                        <td class="p-4 text-gray-600">
                            <div class="flex items-center gap-2">📅 <span>{{ $course->start_date }}</span></div>
                            <div class="flex items-center gap-2 text-xs text-gray-400 mt-1">⏰ <span>{{ $course->time_range }}</span> | <span>{{ $course->timezone }}</span></div>
                        </td>

                        <td class="p-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $course->status->badgeClasses() }}">
                                @if ($course->status === App\Enums\CourseStatus::LIVE)
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                @endif
                                {{ $course->status->label() }}
                            </span>
                            <div class="text-[11px] text-gray-400 mt-1">{{ $course->status_label }}</div>
                        </td>

                        <td class="p-4 text-center">
                            @if ($course->status === App\Enums\CourseStatus::LIVE)
                                <a href="#" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition">انضم الآن 🎥</a>
                            @elseif ($course->status === App\Enums\CourseStatus::COMPLETED)
                                <a href="#" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-medium transition">مشاهدة التسجيل</a>
                            @else
                                <span class="text-gray-300 font-bold">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">لا توجد دورات متاحة حالياً</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- نافذة الـ Popup المنبثقة (Modal) -->
    @if ($showModal && $selectedCourse)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 overflow-y-auto animate-[fade-in_0.2s_ease-out]" wire:click.self="closeModal">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden relative border border-gray-100 my-8">
            <button wire:click="closeModal" class="absolute top-5 left-5 w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center transition cursor-pointer z-10">✕</button>

            <div class="p-6 md:p-8 space-y-6 max-h-[85vh] overflow-y-auto">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4 pb-6 border-b border-gray-100">
                    <div class="space-y-2 flex-1">
                        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-medium rounded-full">
                            {{ $selectedCourse->price ? 'دورة تدريبية مدفوعة' : 'دورة حية مجانية' }}
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $selectedCourse->title }}</h2>
                        <p class="text-sm text-gray-500 leading-relaxed">دورة تعريفية تهتم بتهيئة المشاركين لاستخدام أدوات ومنصات التعلم الإلكتروني بكفاءة عالية.</p>
                    </div>
                    <div class="w-full md:w-36 h-24 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-800 flex items-center justify-center text-white text-xs font-bold shadow-md shrink-0">
                        🖼️ معاينة الدورة
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50/40 rounded-2xl border border-blue-100/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">المدرب</span>
                            <span class="font-bold text-gray-800 text-sm">د. {{ $selectedCourse->instructor_name }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">👨‍🏫</div>
                    </div>

                    <div class="p-4 bg-emerald-50/40 rounded-2xl border border-emerald-100/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">نوع الدورة</span>
                            <span class="font-bold text-gray-800 text-sm">{{ $selectedCourse->price ? $selectedCourse->price . ' دولار' : 'مجانية بالكامل' }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">🏷️</div>
                    </div>

                    <div class="p-4 bg-purple-50/30 rounded-2xl border border-purple-100/50 col-span-1 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">التاريخ والوقت</span>
                            <span class="font-bold text-gray-800 text-sm block">{{ $selectedCourse->start_date }} | {{ $selectedCourse->time_range }}</span>
                            <span class="text-[11px] text-gray-400 mt-0.5 block">{{ $selectedCourse->timezone }}</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg shrink-0">📅</div>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 col-span-1 md:col-span-2 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">حالة الدورة</span>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg border {{ $selectedCourse->status->badgeClasses() }}">{{ $selectedCourse->status->label() }}</span>
                                <span class="text-xs text-gray-600 font-medium">{{ $selectedCourse->status_label }}</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gray-200 text-gray-600 flex items-center justify-center text-lg">⏳</div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-gray-100">
                    <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-bold transition">
                        📄 المادة العلمية (PDF)
                    </a>
                    <a href="https://wa.me/" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-between gap-3 px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-bold transition">
                        <div class="flex items-center gap-2"><span>💬</span><span>تواصل معنا عبر واتساب</span></div>
                        <span>←</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>