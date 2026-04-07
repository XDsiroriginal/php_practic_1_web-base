<?php

namespace Controller;

use Model\Post;
use Model\User;
use Model\Department;

use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;


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
        $departments = Department::all();
        return new View('site.admin_control.user_control', ['users' => $users, 'departments' => $departments]);
    }

    function user_create(): void
    {
        app()->route->redirect('/signup');
    }

    function user_details(Request $request): string
    {
        $user = User::where('user_id', $_GET['user_id'])->first();
        $departments = Department::where('department_id', $user->department_id)->first();
        return (new View())->render('site.admin_control.user_details', ['user' => $user, 'departments' => $departments]);
    }

    function error_403(): string
    {
        return (new View())->render('site.errors.error_403');
    }

    public function signup(Request $request): string
    {
        $departments = Department::all();
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'user_name' => ['required', 'unique:users,user_name'],
                'password' => ['required'],
                'department_id' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            $data = $request->all();
            $data['role'] = 'user';

            if (User::create($data)) {
                app()->route->redirect('/admin_control/user_control');
            }
        }
        return new View('site.signup',['departments' => $departments]);
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
}
