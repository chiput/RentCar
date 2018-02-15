<?php

namespace Kulkul\Test;

use Kulkul\Test\Contracts\TestInterface;
use Kulkul\Test\Traits\TestTrait;
use Kulkul\Test\TestConfig;
use Slim\Http\Response;

class TestServiceProvider implements TestInterface
{
    private $config;

    use TestTrait;

    public function __construct()
    {
        $this->config = new TestConfig();
    }

    public function getCompanyService()
    {
        return $this->config->companyService;
    }

    public function writeCompanyService(Response $response)
    {
        return $response->write($this->getCompanyService());
    }
}
