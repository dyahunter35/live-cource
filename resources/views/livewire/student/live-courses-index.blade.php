<div>
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="page-breadcrumb">
                <a href="#">الرئيسية</a>
                <span class="page-breadcrumb-sep">›</span>
                <span>الدورات المباشرة</span>
            </div>
            <div class="page-title-wrap">
                <div class="page-title-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <h1 class="page-title">الدورات المباشرة</h1>
                    <p class="page-subtitle">تابع دوراتك وجدول جلساتها بكل سهولة</p>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="filter-tabs">
            @foreach ($filters as $filterOption)
                <button
                    wire:click="setFilter('{{ $filterOption['key'] }}')"
                    class="filter-tab {{ $filter === $filterOption['key'] ? 'active' : '' }}"
                >
                    {{ $filterOption['label'] }} ({{ $filterOption['count'] }})
                </button>
            @endforeach
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="courses-table">
                <thead>
                    <tr>
                        <th>
                            الدورة
                            <span class="sort-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </th>
                        <th>
                            الجلسة القادمة
                            <span class="sort-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </th>
                        <th>
                            التاريخ والوقت
                            <span class="sort-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </th>
                        <th>
                            حالة الدورة
                            <span class="sort-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </th>
                        <th style="text-align: center;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $index => $course)
                    @php
                        $iconColors = ['blue', 'green', 'orange', 'purple', 'yellow', 'teal'];
                        $iconColor = $iconColors[$index % count($iconColors)];
                        $icons = [
                            'blue'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#4f6ef7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
                            'green'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
                            'orange' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                            'purple' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>',
                            'yellow' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#eab308" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>',
                            'teal'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
                        ];
                    @endphp
                    <tr wire:key="course-{{ $course->id }}">
                        {{-- Course Column --}}
                        <td>
                            <div class="course-cell">
                                <div class="course-icon course-icon-{{ $iconColor }}">
                                    {!! $icons[$iconColor] !!}
                                </div>
                                <div>
                                    <div class="course-name">{{ $course->title }}</div>
                                    <div class="course-meta">
                                        @if ($course->price)
                                            <span class="course-price-badge course-price-paid">مدفوعة {{ $course->price }} دولار</span>
                                        @else
                                            <span class="course-price-badge course-price-free">دورة حية مجانية</span>
                                        @endif
                                        <span class="course-instructor">د. {{ $course->instructor_name }}</span>
                                    </div>
                                    <button wire:click="loadCourseDetails({{ $course->id }})" class="course-details-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                        التفاصيل
                                    </button>
                                </div>
                            </div>
                        </td>

                        {{-- Session Column --}}
                        <td>
                            <div class="session-title">{{ $course->next_session_title }}</div>
                            @if($course->description ?? null)
                                <div class="session-desc">{{ Str::limit($course->description, 40) }}</div>
                            @endif
                        </td>

                        {{-- Date Column --}}
                        <td>
                            <div class="date-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $course->start_date }}
                            </div>
                            <div class="time-row">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $course->time_range }}
                                @if($course->timezone)
                                    <span>{{ $course->timezone }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Status Column --}}
                        <td>
                            @php
                                $statusClasses = [
                                    'live'            => 'status-live',
                                    'upcoming'        => 'status-upcoming',
                                    'completed'       => 'status-completed',
                                    'not_started'     => 'status-not-started',
                                    'pending_payment' => 'status-pending',
                                ];
                                $statusClass = $statusClasses[$course->status->value] ?? 'status-upcoming';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                @if ($course->status === App\Enums\CourseStatus::LIVE)
                                    <span class="status-pulse"></span>
                                @elseif ($course->status === App\Enums\CourseStatus::UPCOMING)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @elseif ($course->status === App\Enums\CourseStatus::COMPLETED)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                @elseif ($course->status === App\Enums\CourseStatus::NOT_STARTED)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                @elseif ($course->status === App\Enums\CourseStatus::PENDING_PAYMENT)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                @endif
                                {{ $course->status->label() }}
                            </span>
                            @if($course->status_label)
                                <div class="status-sublabel">{{ $course->status_label }}</div>
                            @endif
                        </td>

                        {{-- Actions Column --}}
                        <td style="text-align: center;">
                            @if ($course->status === App\Enums\CourseStatus::LIVE)
                                <a href="#" class="action-btn action-btn-join">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                                    </svg>
                                    انضم الآن
                                </a>
                            @elseif ($course->status === App\Enums\CourseStatus::COMPLETED)
                                <a href="#" class="action-btn action-btn-watch">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>
                                    </svg>
                                    مشاهدة التسجيل
                                </a>
                            @elseif ($course->status === App\Enums\CourseStatus::PENDING_PAYMENT)
                                <a href="#" class="action-btn action-btn-pay">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                    إتمام الدفع
                                </a>
                            @else
                                <span class="action-dash">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d9e0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <p>{{ $search !== '' || $filter !== 'all' ? 'لا توجد نتائج مطابقة للبحث' : 'لا توجد دورات متاحة حالياً' }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="table-footer">
            <div class="total-count">إجمالي الدورات: <span>{{ $courses->count() }}</span></div>
            <div class="pagination">
                <button class="page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Course Details Modal --}}
    @if ($showModal && $selectedCourse)
    <div class="modal-overlay" wire:click.self="closeModal">
        <div class="modal-card">
            {{-- Modal Header --}}
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <div class="modal-title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="modal-title">تفاصيل الدورة</span>
                </div>
                <button wire:click="closeModal" class="modal-close">×</button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                {{-- Course Top Section --}}
                <div class="modal-course-top">
                    <div class="modal-course-info">
                        <h2 class="modal-course-name">{{ $selectedCourse->title }}</h2>
                        <span class="modal-course-type-badge {{ $selectedCourse->price ? 'paid' : '' }}">
                            {{ $selectedCourse->price ? 'دورة تدريبية مدفوعة' : 'دورة حية مجانية' }}
                        </span>
                        <p class="modal-course-desc">
                            دورة تعريفية لتهيئة المشاركين لاستخدام أدوات ومنصات التعلم الإلكتروني بكفاءة.
                        </p>
                    </div>
                    <div class="modal-course-image">
                        <div style="text-align:center;padding:12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" width="36" height="36" style="margin-bottom:6px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            <div style="font-size:11px;opacity:0.7;">{{ $selectedCourse->title }}</div>
                        </div>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="modal-info-grid">
                    {{-- Instructor --}}
                    <div class="modal-info-card">
                        <div>
                            <div class="modal-info-label">المدرب</div>
                            <div class="modal-info-value">د. {{ $selectedCourse->instructor_name }}</div>
                        </div>
                        <div class="modal-info-icon icon-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Course Type --}}
                    <div class="modal-info-card">
                        <div>
                            <div class="modal-info-label">نوع الدورة</div>
                            <div class="modal-info-value">{{ $selectedCourse->price ? $selectedCourse->price . ' دولار' : 'مجانية' }}</div>
                        </div>
                        <div class="modal-info-icon icon-green">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20.59 13.41 15 7.82 9.41 13.41"/><line x1="15" y1="7.82" x2="15" y2="19.41"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Date & Time --}}
                    <div class="modal-info-card">
                        <div>
                            <div class="modal-info-label">التاريخ والوقت</div>
                            <div class="modal-info-value">{{ $selectedCourse->start_date }}</div>
                            <div class="modal-info-sub">{{ $selectedCourse->time_range }}</div>
                            @if($selectedCourse->timezone)
                                <div class="modal-info-sub">{{ $selectedCourse->timezone }}</div>
                            @endif
                        </div>
                        <div class="modal-info-icon icon-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Sessions Count --}}
                    <div class="modal-info-card">
                        <div>
                            <div class="modal-info-label">عدد جلسات الدورة</div>
                            <div class="modal-info-value">3 جلسات</div>
                        </div>
                        <div class="modal-info-icon icon-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Course Status --}}
                <div class="modal-status-section">
                    <div class="modal-status-content">
                        <div class="modal-status-label">حالة الدورة</div>
                        @php
                            $statusClasses = [
                                'live'            => 'status-live',
                                'upcoming'        => 'status-upcoming',
                                'completed'       => 'status-completed',
                                'not_started'     => 'status-not-started',
                                'pending_payment' => 'status-pending',
                            ];
                            $mStatusClass = $statusClasses[$selectedCourse->status->value] ?? 'status-upcoming';
                        @endphp
                        <div style="display:flex;flex-direction:column;align-items:flex-start;gap:6px;background:#f5f7fa;border-radius:12px;padding:12px 16px;width:fit-content;">
                            <span class="status-badge {{ $mStatusClass }}">
                                @if ($selectedCourse->status === App\Enums\CourseStatus::LIVE)
                                    <span class="status-pulse"></span>
                                @elseif ($selectedCourse->status === App\Enums\CourseStatus::UPCOMING)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @elseif ($selectedCourse->status === App\Enums\CourseStatus::COMPLETED)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                @endif
                                {{ $selectedCourse->status->label() }}
                            </span>
                            @if($selectedCourse->status_label)
                                <span class="modal-status-sublabel">{{ $selectedCourse->status_label }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-info-icon icon-gray">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="modal-footer">
                    <a href="#" class="modal-btn-pdf">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="#dc2626" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline stroke="#dc2626" points="14 2 14 8 20 8"/>
                            <line stroke="#dc2626" x1="16" y1="13" x2="8" y2="13"/>
                            <line stroke="#dc2626" x1="16" y1="17" x2="8" y2="17"/>
                            <polyline stroke="#dc2626" points="10 9 9 9 8 9"/>
                        </svg>
                        المادة العلمية
                    </a>
                    <a href="https://wa.me/" target="_blank" class="modal-btn-whatsapp">
                        <div class="modal-btn-whatsapp-left">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
                            </svg>
                            <div class="modal-btn-whatsapp-text">
                                <div class="modal-btn-whatsapp-title">تواصل معنا</div>
                                <div class="modal-btn-whatsapp-sub">عبر واتساب</div>
                            </div>
                        </div>
                        <span class="modal-btn-arrow">›</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>