<?php

namespace Kulkul\Test\Traits;

use Slim\Http\Response;

trait TestTrait
{
    public function getCompanyName()
    {
        return $this->config->companyName;
    }

    public function writeCompanyName(Response $response)
    {
        return $response->write($this->getCompanyName());
    }
}
