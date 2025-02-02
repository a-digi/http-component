<?php

declare(strict_types=1);

namespace AriAva\Http\Request;

use AriAva\Http\Request\Body\Factory\PropertiesFactoryInterface;
use AriAva\Http\Request\Body\PropertiesBag;
use AriAva\Http\Request\Headers\HeadersBag;
use AriAva\Http\Request\Headers\HeadersFactory;
use AriAva\Http\Request\Uri\Uri;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

final class Request implements RequestInterface
{
    private RequestMethod $requestMethod;
    private PropertiesBag $propertiesBag;
    private UriInterface $uri;
    private HeadersBag $headers;

    public function __construct(private readonly array $serverArguments, PropertiesFactoryInterface $propertiesFactory)
    {
        $this->handleOptionsRequest($serverArguments);
        $this->requestMethod = RequestMethod::from($serverArguments['REQUEST_METHOD']);
        $this->propertiesBag = $propertiesFactory->handle($this->requestMethod);
        $this->uri = Uri::fromCurrentUri();
        $this->headers = HeadersFactory::create();
    }

    public function getPropertiesBag(): PropertiesBag
    {
        return $this->propertiesBag;
    }

    public function getServerArguments(): array
    {
        return $this->serverArguments;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getProtocolVersion(): string
    {
        return $this->uri->getScheme();
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        $instance = clone $this;
        $instance->uri = $instance->uri->withScheme($version);

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    public function hasHeader(string $name): bool
    {
        return $this->headers->has($name);
    }

    public function getHeader(string $name): array
    {
        if ($this->hasHeader($name)) {
            return $this->headers->get($name)->toArray();
        }

        return [];
    }

    public function getHeaderLine(string $name): string
    {
        die();
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        return clone $this;
    }

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        return clone $this;
    }

    public function withoutHeader(string $name): MessageInterface
    {
        return clone $this;
    }

    public function getBody(): StreamInterface
    {
        die();
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        return clone $this;
    }

    public function getRequestTarget(): string
    {
        return $this->uri->getPath();
    }

    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        return clone $this;
    }

    public function getMethod(): string
    {
        return $this->requestMethod->value;
    }

    public function withMethod(string $method): RequestInterface
    {
        $instance = clone $this;
        $instance->requestMethod = RequestMethod::from($method);

        return $instance;
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {
        $instance = clone $this;
        $instance->uri = $uri;

        return $instance;
    }

    private function handleOptionsRequest(array $serverArguments): void
    {
        if ($serverArguments['REQUEST_METHOD'] !== 'OPTIONS') {
            return;
        }

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
        die();
    }
}
