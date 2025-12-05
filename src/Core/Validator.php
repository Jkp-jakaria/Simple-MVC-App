<?php
declare(strict_types=1);

namespace App\Core;

class Validator
{
    public static function isEmail(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isNumeric(string $value): bool
    {
        return (bool) preg_match('/^\d+$/', $value);
    }

    public static function isTextWithSpacesNumbers(string $value, int $maxLength): bool
    {
        if (mb_strlen($value) > $maxLength) {
            return false;
        }
        return (bool) preg_match('/^[\p{L}\p{N} ]+$/u', $value);
    }

    public static function isTextWithSpaces(string $value): bool
    {
        return (bool) preg_match('/^[\p{L} ]+$/u', $value);
    }

    public static function maxWords(string $text, int $maxWords): bool
    {
        $words = preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        return count($words) <= $maxWords;
    }
}
