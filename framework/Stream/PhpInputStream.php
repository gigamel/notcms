<?php

declare(strict_types=1);

namespace Framework\Stream;

final class PhpInputStream extends Stream
{
    public function __construct()
    {
        parent::__construct('php://input', 'rb');
    }
}
