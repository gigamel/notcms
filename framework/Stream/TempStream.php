<?php

declare(strict_types=1);

namespace Framework\Stream;

final class TempStream extends Stream
{
    public function __construct()
    {
        parent::__construct('php://temp', 'w+b');
    }
}
