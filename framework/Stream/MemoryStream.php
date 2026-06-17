<?php

declare(strict_types=1);

namespace Framework\Stream;

final class MemoryStream extends Stream
{
    public function __construct()
    {
        parent::__construct('php://memory', 'w+b');
    }
}
