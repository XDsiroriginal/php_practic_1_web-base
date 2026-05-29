<?php

namespace Controller;

use Couchbase\Role;
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

    public function repair(): string
    {
        return new View('site.repair');
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
        $userId = $request->get('user_id');
        $user = User::where('user_id', $userId)->first();
        if (!$user) {
            return $this->error_403();
        }

        $departments = Department::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name'          => ['required'],
                'user_name'     => ['required'],
                'role'          => ['required'],
                'department_id' => ['required'],
                'password'      => ['nullable', 'min:4'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'min'      => 'Поле :field должно содержать минимум :min символов'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.admin_control.user_details', [
                    'user' => $user,
                    'departments' => $departments,
                    'errors' => $validator->errors(),
                ]);
            }

            $data = $request->all();
            if (!empty($data['password'])) {
                $data['password'] = md5($data['password']);
            } else {
                unset($data['password']);
            }

            $allowed = ['name', 'user_name', 'role', 'department_id', 'password'];
            $updateData = array_intersect_key($data, array_flip($allowed));
            $user->update($updateData);
            app()->route->redirect('/admin_control/user_control');
        }

        return (new View())->render('site.admin_control.user_details', [
            'user' => $user,
            'departments' => $departments,
        ]);
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
                'user_name' => ['required', 'unique:user,user_name'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup', [
                    'departments' => $departments,
                    'message' => 'заполните все необходимые поля'
                ]);
            }

            $data = $request->all();
            $data['role'] = 'user';

            if (User::create($data)) {
                app()->route->redirect('/admin_control/user_control');
                return false;
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
