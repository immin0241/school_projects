<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // 테스트에서는 프론트엔드 빌드 산출물(Vite manifest) 없이 화면을 렌더링한다.
        $this->withoutVite();
    }
}
