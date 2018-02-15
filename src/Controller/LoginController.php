<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Kulkul\Authentication\AuthServiceProvider;

class LoginController extends Controller
{
    public function __invoke(Request $request, Response $response, Array $args)
    {
        $redirect = $request->getParam('redirect');
        $this->session->set('redirectLogin', $redirect);

        $data['loginError'] = $this->session->getFlash('loginError');

        $data['app_profile'] = $this->app_profile;

        return $this->renderer->render($response, 'login', $data);
    }

    public function submit(Request $request, Response $response, Array $args)
    {
        $body = $request->getParsedBody();

        $this->validation->validate([
            'username'  => [$body['name'], 'required'],
            'password'   => [$body['password'], 'required']
        ]);

        $auth = new AuthServiceProvider();

        $authResponse = $auth->auth($body);

        if ($this->validation->passes() && $authResponse) {
            $redirect = $this->session->get('redirectLogin');
            $this->session->set('redirectLogin', null);

            $redirectTo = $this->router->pathFor($redirect);

            return $this->response->withRedirect($redirectTo);
        } else {
            $this->session->setFlash('loginError', 'Invalid username or password.');
            $redirectTo = $this->router->pathFor('login');

            return $this->response->withRedirect($redirectTo, 401);
        }

        return $response;
    }

    public function logout(Request $request, Response $response, Array $args)
    {
        $auth = new AuthServiceProvider();

        $auth->shutDown();

        $redirectTo = $this->router->pathFor('login');
        return $this->response->withRedirect($redirectTo);
    }
}
