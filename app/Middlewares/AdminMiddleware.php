<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не авторизован, то редирект на страницу входа
        if (Auth::user()->role !== 'ADMIN') {
            app()->route->redirect('/errors/error_403');
        }
    }
}
