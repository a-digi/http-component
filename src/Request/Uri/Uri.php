<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Uri;

use Psr\Http\Message\UriInterface;

final class Uri implements UriInterface
{
    /** @phpstan-ignore property.unusedType */
    private string|null $scheme;

    /** @phpstan-ignore property.unusedType */
    private string|null $host;

    private int|null $port;

    /** @phpstan-ignore property.unusedType */
    private string|null $path;

    /** @phpstan-ignore property.unusedType */
    private string|null $query;

    /** @phpstan-ignore property.unusedType */
    private string|null $fragment;

    /** @phpstan-ignore property.unusedType */
    private string|null $userInfo;

    private string $uri;

    private UriParser $uriParser;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->uriParser = UriParser::create();
    }

    public static function fromString(string $uri): self
    {
        return new self($uri);
    }

    public static function fromCurrentUri(): self
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

        return new self($protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        $authority = $this->host;
        if ($this->userInfo !== '') {
            $authority = $this->userInfo.'@'.$authority;
        }

        if ($this->port !== null) {
            $authority .= ':'.$this->port;
        }

        return $authority;
    }

    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme(string $scheme): UriInterface
    {
        $instance = clone $this;
        $instance->scheme = $scheme;

        return $instance;
    }

    public function withUserInfo(string $user, ?string $password = null): UriInterface
    {
        $info = $this->uriParser->filterUserInfoComponent($user);
        if ($password !== null) {
            $info .= ':'.$this->uriParser->filterUserInfoComponent($password);
        }

        $instance = clone $this;
        $instance->userInfo = $info;

        return $instance;
    }

    public function withHost(string $host): UriInterface
    {
        $instance = clone $this;
        $instance->host = $host;

        return $instance;
    }

    public function withPort(?int $port): UriInterface
    {
        $instance = clone $this;
        $instance->port = $port;

        return $instance;
    }

    public function withPath(string $path): UriInterface
    {
        $instance = clone $this;
        $instance->path = $path;

        return $instance;
    }

    public function withQuery(string $query): UriInterface
    {
        $instance = clone $this;
        $instance->query = $query;

        return $instance;
    }

    public function withFragment(string $fragment): UriInterface
    {
        $instance = clone $this;
        $instance->fragment = $fragment;

        return $instance;
    }

    public function __toString(): string
    {
        return $this->uri;
    }

    public function parseUriString(string $url): array
    {
        $prefix = '';
        if (preg_match('%^(.*://\[[0-9:a-f]+\])(.*?)$%', $url, $matches)) {
            $prefix = $matches[1];
            $url = $matches[2];
        }
        $encodedUrl = preg_replace_callback(
            '%[^:/@?&=#]+%usD',
            static function ($matches) {
                return urlencode($matches[0]);
            },
            $url
        );

        $result = parse_url($prefix . $encodedUrl);

        if ($result === false) {
            return [];
        }

        return array_map('urldecode', $result);
    }
}
