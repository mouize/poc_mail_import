<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Illuminate\Http\RedirectResponse;

class GmailOauthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return LaravelGmail::redirect();
    }

    public function callback(): RedirectResponse
    {
        if (!request()->get('error')) {
            LaravelGmail::makeToken();
        }

        return redirect()->to('/');
    }

    public function logout(): RedirectResponse
    {
        LaravelGmail::logout();

        return redirect()->to('/');
    }
}
