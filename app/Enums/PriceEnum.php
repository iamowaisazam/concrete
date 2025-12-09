<?php


namespace App\Enums;

enum PriceEnum:int
{
    case ZERO = 0;
    case HUNDRED = 100;
    case TWO_HUNDRED = 200;
    case FOUR_HUNDRED = 400;
    case EIGHT_HUNDRED = 800;
    case THOUSAND = 1000;
    case TWO_THOUSAND = 2000;

    public function label(): string
    {
        return match($this) {
            self::ZERO => 'Free',
            self::HUNDRED => '100 PKR',
            self::TWO_HUNDRED => '200 PKR',
            self::FOUR_HUNDRED => '400 PKR',
            self::EIGHT_HUNDRED => '800 PKR',
            self::THOUSAND => '1,000 PKR',
            self::TWO_THOUSAND => '2,000 PKR',
        };
    }

    /**
     * For dropdowns or seeding
     */
    public static function options(): array
    {
        return array_map(fn($e) => [
            'value' => $e->value,
            'label' => $e->label(),
        ], self::cases());
    }
}

