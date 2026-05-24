<?php

declare(strict_types=1);

namespace RentEase\Support;

final class Validator
{
    public static function requiredString(array $input, string $key, int $minLength = 1, int $maxLength = 255): string
    {
        $value = trim((string) ($input[$key] ?? ''));
        $length = mb_strlen($value);

        if ($length < $minLength || $length > $maxLength) {
            throw new ValidationException([$key => sprintf('Must be between %d and %d characters', $minLength, $maxLength)]);
        }

        return $value;
    }

    public static function email(array $input, string $key): string
    {
        $value = trim((string) ($input[$key] ?? ''));
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException([$key => 'Invalid email address']);
        }
        return $value;
    }

    public static function password(array $input, string $key = 'password'): string
    {
        $value = self::requiredString($input, $key, 8, 128);

        if (!preg_match('/[0-9]/', $value)) {
            throw new ValidationException([$key => 'Password must contain at least one number']);
        }

        if (!preg_match('/[^a-zA-Z0-9]/', $value)) {
            throw new ValidationException([$key => 'Password must contain at least one special character']);
        }

        return $value;
    }

    public static function uuid(array $input, string $key): string
    {
        $value = trim((string) ($input[$key] ?? ''));
        if (!preg_match('/^[0-9a-fA-F-]{36}$/', $value)) {
            throw new ValidationException([$key => 'Invalid UUID']);
        }
        return $value;
    }

    public static function integer(array $input, string $key, int $min = 1): int
    {
        $value = filter_var($input[$key] ?? null, FILTER_VALIDATE_INT);

        if ($value === false || $value < $min) {
            throw new ValidationException([$key => sprintf('Must be an integer >= %d', $min)]);
        }

        return (int) $value;
    }

    /**
     * @return array{0: string, 1: string}
     */
    public static function dateRange(array $input, string $startKey = 'start_date', string $endKey = 'end_date'): array
    {
        $start = trim((string) ($input[$startKey] ?? ''));
        $end = trim((string) ($input[$endKey] ?? ''));

        if (!self::isIsoDate($start) || !self::isIsoDate($end)) {
            throw new ValidationException([$startKey => 'Invalid date', $endKey => 'Invalid date']);
        }

        if ($start > $end) {
            throw new ValidationException([$endKey => 'End date must be after start date']);
        }

        return [$start, $end];
    }

    private static function isIsoDate(string $value): bool
    {
        $d = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        return $d !== false && $d->format('Y-m-d') === $value;
    }
}