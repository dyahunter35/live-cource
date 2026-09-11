<?php

namespace App\Enums;

enum CourseStatus: string
{
    case LIVE = 'live';
    case UPCOMING = 'upcoming';
    case COMPLETED = 'completed';
    case NOT_STARTED = 'not_started';
    case PENDING_PAYMENT = 'pending_payment';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::LIVE => 'مباشر الآن',
            self::UPCOMING => 'قادمة',
            self::COMPLETED => 'مكتملة',
            self::NOT_STARTED => 'لم تبدأ بعد',
            self::PENDING_PAYMENT => 'بانتظار السداد',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::LIVE => 'bg-red-50 text-red-600 border-red-100',
            self::UPCOMING => 'bg-blue-50 text-blue-600 border-blue-100',
            self::COMPLETED => 'bg-green-50 text-green-600 border-green-100',
            self::NOT_STARTED => 'bg-orange-50 text-orange-600 border-orange-100',
            self::PENDING_PAYMENT => 'bg-amber-50 text-amber-600 border-amber-100',
        };
    }
}
