<?php

declare(strict_types=1);

namespace Framework\Http\Factory;

final readonly class FilesParser
{
    public static function parse(array $files): array
    {
        $parsedFiles = [];
        foreach ($files as $file) {
            assert(
                isset($file['tmp_name'])
                && isset($file['error'])
                && isset($file['size'])
                && isset($file['name'])
                && isset($file['type'])
            );

            if (0 === ($file['size'][0] ?? $file['size'])) {
                continue;
            }

            if (!is_array($file['name'])) {
                $parsedFiles[] = $file;

                continue;
            }

            foreach (array_keys($file['name']) as $key) {
                $parsedFiles[] = [
                    'tmp_name' => $file['tmp_name'][$key],
                    'error' => $file['error'][$key],
                    'size' => $file['size'][$key],
                    'name' => $file['name'][$key],
                    'type' => $file['type'][$key],
                ];
            }
        }

        return $parsedFiles;
    }
}
