<?php

namespace App\Enums;

use App\Contracts\Types\HasAll;
use App\Contracts\Types\HasColor;
use App\Contracts\Types\HasLabel;

enum PaymentGateway: int implements HasAll, HasColor, HasLabel
{
    case COD = 0;
    case GCASH = 1;
    case PAYSTACK = 2;
    case FLUTTERWAVE = 3;

    public static function all(): array
    {
        return [
            self::COD,
            self::GCASH,
            self::PAYSTACK,
            self::FLUTTERWAVE,
        ];
    }

    public function color(): string
    {
        return match ($this) {
            self::COD => 'secondary',
            self::GCASH => 'primary',
            self::PAYSTACK => 'success',
            self::FLUTTERWAVE => 'warning',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::COD => 'Cash on Delivery',
            self::GCASH => 'GCash',
            self::PAYSTACK => 'Paystack',
            self::FLUTTERWAVE => 'Flutterwave',
        };
    }
}
