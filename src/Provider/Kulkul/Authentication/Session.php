<?php

namespace Kulkul\Authentication;

use Kulkul\Authentication\Container;

class Session
{
    public static function getActiveUser()
    {
        return Container::get('session')->get('activeUser');
    }

    public static function setActiveUser($activeUser)
    {
        return Container::get('session')->set('activeUser', $activeUser);
    }

    public static function destroy()
    {
        return Container::get('session')->set('activeUser', null);
    }
}
