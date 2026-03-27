<?php

namespace Controller;

use Model\Post;
use Model\User;
use Model\Department;

use Src\View;
use Src\Request;
use Src\Auth\Auth;


class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        $departments = Department::all();

        if ($request->method === 'POST') {
            if (User::create([
                'name' => $_POST['name'] ?? null,
                'user_name' => $_POST['user_name'] ?? null,
                'password' => $_POST['password'] ?? null,
                'department_id' => $_POST['department_id'] ?? null,
                'role' => 'user'
            ])) {
                app()->route->redirect('/hello');
            }
        }

        return new View('site.signup', [
            'departments' => $departments
        ]);
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt([
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
        ])) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function equipment(): string
    {
        return new View('site.equipment');
    }

    public function repair(): string
    {
        return new View('site.repair');
    }

    public function department() : string
    {
        return new View('site.department');
    }

    function department_control() : string
    {
        return new View('site.admin_control.department_control');
    }
    function equipment_control() : string
    {
        return new View('site.admin_control.equipment_control');
    }
    function user_control() : string
    {
        $users = User::all();
        return new View('site.admin_control.user_control', ['users' => $users]);
    }

    function user_create(): void
    {
        app()->route->redirect('/signup');
    }
}
