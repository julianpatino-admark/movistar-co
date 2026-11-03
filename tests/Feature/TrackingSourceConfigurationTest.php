<?php

namespace Tests\Feature;

use Admark\Tracking\Http\Services\ConfigService;
use Admark\Tracking\Http\Services\TsourceService;
use Tests\TestCase;

class TrackingSourceConfigurationTest extends TestCase
{
    public function test_configured_source_driver_uses_default_provider_for_unknown_source(): void
    {
        $sources = new TsourceService(new ConfigService());

        $this->assertSame(
            config('tracking.source_phones.default.provider'),
            $sources->getProviderName('unconfigured-source')
        );
        $this->assertSame(
            config('tracking.source_phones.default.batch_id'),
            $sources->getBatchId('unconfigured-source')
        );
    }
}
