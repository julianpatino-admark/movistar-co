<?php

namespace Admark\GoContact;

class GoContactSubmissionAttempted
{
    public function __construct(
        public ?string $formId,
        public ?string $providerLeadId,
        public bool $successful,
        public string $stage,
        public ?int $httpStatus,
        public ?string $error,
        public array $diagnostics,
        public int $durationMs
    ) {
    }
}
