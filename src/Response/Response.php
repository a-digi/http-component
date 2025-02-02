<?php

declare(strict_types=1);

namespace AriAva\Http\Response;

use AriAva\Http\ContentType;
use AriAva\Http\HttpCode;

final readonly class Response implements ResponseInterface
{
    public function __construct(
        private string $content,
        private HttpCode $code,
        private ContentType $contentType = ContentType::JSON,
        private array $headers = [],
    ) {
        $this->__toString();
    }

    public function __toString(): string
    {
        http_response_code($this->code->value);
        header('Content-Type: ' . $this->contentType->value);
        if (0 < count($this->headers)) {
            foreach ($this->headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        $this->output($this->content);

        return $this->content;
    }

    private function output(string $output): void
    {
        echo $output;
    }
}
