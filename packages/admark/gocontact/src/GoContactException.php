<?php

namespace Admark\GoContact;

use RuntimeException;
use Throwable;

class GoContactException extends RuntimeException
{
    private ?int $status;
    private array $diagnostics;

    public function __construct(
        string $message,
        ?int $httpStatus = null,
        ?Throwable $previous = null,
        array $diagnostics = []
    ) {
        $this->status = $httpStatus;
        $this->diagnostics = $diagnostics;
        parent::__construct($message, 0, $previous);
    }

    public function httpStatus(): ?int
    {
        return $this->status;
    }

    public function diagnostics(): array
    {
        return $this->diagnostics;
    }
}
