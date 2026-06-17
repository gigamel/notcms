<?php

declare(strict_types=1);

namespace Framework\Http\Factory;

final readonly class HeadersParser
{
    public static function parse(array $server): array
    {
        $headers = [];
        foreach ($server as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                continue;
            }

            if (!str_starts_with($key, 'HTTP_')) {
                continue;
            }

            $headers[strtolower(substr($key, 5))] = explode(',', $value);
        }

        return $headers;
    }
}
