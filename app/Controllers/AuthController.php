<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/admin');
        }

        $this->render('auth/login', [
            'title' => 'Entrar',
            'email' => Session::pullFlash('old_email', ''),
        ], 'layouts/blank');
    }

    public function login(): void
    {
        Csrf::verify();

        $email    = $this->input('email');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            Session::flash('error', 'Informe e-mail e senha.');
            Session::flash('old_email', $email);
            $this->redirect('/login');
        }

        if (!Auth::attempt($email, (string) $password)) {
            // Mensagem generica: nao revela se o e-mail existe.
            Session::flash('error', 'Credenciais invalidas.');
            Session::flash('old_email', $email);
            $this->redirect('/login');
        }

        $intended = Session::get('_intended', '/admin');
        Session::forget('_intended');

        $this->redirect(is_string($intended) ? $intended : '/admin');
    }

    public function logout(): void
    {
        Csrf::verify();
        Auth::logout();

        Session::start();
        Session::flash('success', 'Sessao encerrada.');

        $this->redirect('/');
    }
}
