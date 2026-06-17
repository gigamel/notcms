<?php

declare(strict_types=1);

namespace Framework\Http\Factory;

use Framework\Http\Protocol\UploadedFile;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

final readonly class UploadedFileFactory
{
    public function createUploadedFile(
        StreamInterface $stream,
        ?int $size = null,
        int $error = UPLOAD_ERR_OK,
        ?string $clientFilename = null,
        ?string $clientMediaType = null,
    ): UploadedFileInterface {
        return new UploadedFile(
            $stream,
            $size ?? $stream->getSize(),
            $error,
            $clientFilename,
            $clientMediaType,
        );
    }
}
