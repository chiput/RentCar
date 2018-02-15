<?php

namespace Kulkul\Authentication;

use Kulkul\Authentication\Container;
use Kulkul\Authentication\Session;
use App\Model\User;

class AuthServiceProvider
{
    public function __construct()
    {

    }

    public function auth($userInfo)
    {
        $user = $this->getUser($userInfo['name']);
        // $sessionValue = [
        //              'id' => '1',
        //              'name' => 'id25',
        //              'password' => 'id25',
        //          ];
        //          Session::setActiveUser($sessionValue);
        //          return true;
        if ($user->count() != 1) {
            return false;
        } else {
            $user = $user->first();
            $dbPassword = Container::get('encrypter')->decrypt($user->password);
            if ($dbPassword == $userInfo['password']) {
                $sessionValue = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'password' => $dbPassword,
                ];
                Session::setActiveUser($sessionValue);
                return true;
            } else {
                return false;
            }
        }

    }

    public function reAuth()
    {
        $activeUser = Session::getActiveUser();
        if (is_null($activeUser)) return false;

        $user = $this->getUser($activeUser['name']);

        if ($user->count() != 1) {
            // do nothing
        } else {
            $user = $user->first();
            $dbPassword = Container::get('encrypter')->decrypt($user->password);
            if (
                $dbPassword == $activeUser['password'] &&
                $activeUser['id'] == $user->id
            ) {
                $sessionValue = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'password' => $dbPassword,
                ];
                Session::setActiveUser($sessionValue);
                return true;
            } else {
            }
        }
        Session::destroy();
        return false;
        // $sessionValue = [
        //              'id' => '1',
        //              'name' => 'id25',
        //              'password' => 'id25',
        //          ];
        //          Session::setActiveUser($sessionValue);
        //          return true;
    }

    public function shutDown()
    {
        Session::destroy();
        return true;
    }

    protected function getUser($username)
    {
        $user = User::where('name', $username)->get();
        return $user;
    }

    public function user()
    {
        $activeUser = Session::getActiveUser();
        if (is_null($activeUser)) return false;

        $user = $this->getUser($activeUser['name']);

        return $user;
    }
}
