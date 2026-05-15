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
            throw new \InvalidArgumentException(sprintf('Invalid %s', $key));
        }

        return $value;
    }

    public static function email(array $input, string $key): string
    {
        $value = trim((string) ($input[$key] ?? ''));
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }
        return $value;
    }

    public static function uuid(array $input, string $key): string
    {
        $value = trim((string) ($input[$key] ?? ''));
        if (!preg_match('/^[0-9a-fA-F-]{36}$/', $value)) {
            throw new \InvalidArgumentException(sprintf('Invalid %s', $key));
        }
        return $value;
    }

    public static function integer(array $input, string $key, int $min = 1): int
    {
        $value = filter_var($input[$key] ?? null, FILTER_VALIDATE_INT);

        if ($value === false || $value < $min) {
            throw new \InvalidArgumentException(sprintf('Invalid %s', $key));
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
            throw new \InvalidArgumentException('Invalid dates supplied');
        }

        if ($start > $end) {
            throw new \InvalidArgumentException('End date must be after start date');
        }

        return [$start, $end];
    }

    private static function isIsoDate(string $value): bool
    {
        $d = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        return $d !== false && $d->format('Y-m-d') === $value;
    }
}