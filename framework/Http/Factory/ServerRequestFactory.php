<?php

declare(strict_types=1);

namespace Framework\Http\Factory;

use Framework\Http\Protocol\Enum\Method;
use Framework\Http\Protocol\ServerRequest;
use Framework\Http\Protocol\Uri;
use Framework\Stream\Stream;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

final readonly class ServerRequestFactory
{
    public function __construct(
        protected array $queryParams = [],
        protected array $formParams = [],
        protected array $serverParams = [],
        protected array $cookies = [],
        protected array $files = [],
    ) {}
    
    public static function fromGlobals(): ServerRequestInterface
    {
        return (new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES,
        ))->createServerRequest(
            $_SERVER['REQUEST_METHOD'] ?? Method::GET,
            $_SERVER['REQUEST_URI'] ?? '',
        );
    }
    
    public function createServerRequest(
        string $method,
        $uri,
        array $serverParams = [],
    ): ServerRequestInterface {
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }
        
        if (!$uri instanceof UriInterface) {
            throw new InvalidArgumentException(
                'Uri should be type of string|UriInterface',
            );
        }
        
        $headers = HeadersParser::parse($serverParams ?: $this->serverParams);
        $uploadFileFactory = new UploadedFileFactory();
        
        return new ServerRequest(
            $method,
            $uri,
            $headers,
            $this->queryParams,
            $this->formParams,
            $serverParams ?: $this->serverParams,
            $this->cookies ?: ($headers['cookie'] ?? []),
            array_map(
                static function (array $file) use ($uploadFileFactory) {
                    return $uploadFileFactory->createUploadedFile(
                        new Stream($file['tmp_name'], 'r'),
                        $file['size'],
                        $file['error'],
                        $file['name'],
                        $file['type'],
                    );
                },
                FilesParser::parse($this->files),
            ),
        );
    }
}
