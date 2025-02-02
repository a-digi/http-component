<?php

declare(strict_types=1);

namespace AriAva\Http\Response;

use AriAva\Http\ContentType;
use AriAva\Http\HttpCode;

final readonly class JsonResponse implements ResponseInterface
{
    public function __construct(
        private array $content,
        private HttpCode $code,
        private array $headers = [],
        private mixed $customSerializer = null,
    ) {
        $this->__toString();
    }

    public function __toString(): string
    {
        http_response_code($this->code->value);
        header('Content-Type: ' . ContentType::JSON->value);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
        header("Access-Control-Allow-Headers: X-Requested-With");
        if (0 < count($this->headers)) {
            foreach ($this->headers as $name => $value) {
                header($name . ': ' . $value);
            }
        }

        $content = $this->jsonSerialize();
        $this->output($content);

        return $content;
    }

    public function jsonSerialize(): string
    {
        if (null !== $this->customSerializer) {
            return $this->customSerializer->serialize(
                [
                    'message' => $this->content,
                    'status' => $this->code->getStatus($this->code),
                    'httpCode' => $this->code->value,
                ]
            );
        }

        try {
            return json_encode(
                [
                    'message' => $this->content,
                    'status' => $this->code->getStatus($this->code),
                    'httpCode' => $this->code->value,
                ],
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {
            http_response_code($this->code->value);
            header('Content-Type: ');
            echo "Invalid JSON format";
            die();
        }
    }

    private function output(string $output): void
    {
        echo $output;
    }
}
