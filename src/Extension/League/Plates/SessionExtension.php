<?php

namespace App\Extension\League\Plates;

use League\Plates\Engine as PlatesEngine;
use League\Plates\Extension\ExtensionInterface;
use Aura\Session\Segment as SessionSegment;
use Kulkul\Authentication\Session as KulkulSession;

class SessionExtension implements ExtensionInterface
{
    private $session;

    public function __construct(SessionSegment $session)
    {
        $this->session = $session;
    }

    public function register(PlatesEngine $engine)
    {
        $engine->registerFunction('getSessionFlash', [$this->session, 'getFlash']);
        $engine->registerFunction('getSession', [$this->session, 'get']);
        $engine->registerFunction('getActiveUser', [$this, 'activeUser']);
    }

    public function activeUser()
    {
        return KulkulSession::getActiveUser();
    }
}
