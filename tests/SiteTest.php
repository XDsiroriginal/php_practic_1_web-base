<?php
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
/**
* @dataProvider additionProvider
* @runInSeparateProcess
*/
    public function testSignup(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем занятый логин из базы данных
        if ($userData['user_name'] === 'user name is busy') {
            $userData['user_name'] = User::get()->first()->user_name;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Site())->signup($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли пользователь в базу данных
        $this->assertTrue((bool)User::where('user_name', $userData['user_name'])->count());
        //Удаляем созданного пользователя из базы данных
        User::where('user_name', $userData['user_name'])->delete();

        //Проверяем редирект при успешной регистрации$this->assertContains($message, xdebug_get_headers());
        }

//Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'user_name' => '', 'password' => ''],
                '<h3></h3>'
            ],
            ['POST', ['name' => '', 'user_name' => '', 'password' => ''],
                '<h3>{"name":["Поле name пусто"],"user_name":["Поле user name пусто"],"password":["Поле password пусто"]}</h3>',
            ], ['POST', ['name' => 'admin', 'user_name' => 'user name is busy', 'password' => 'admin'],
                '<h3>{"user_name":["Поле user name должно быть уникально"]}</h3>',
            ],
            ['POST', ['name' => 'admin', 'user_name' => md5(time()), 'password' => 'admin'],
                'Location: /hello',
            ],
        ];
    }

    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = '/var/www';

   //Создаем экземпляр приложения
   $GLOBALS['app'] = new Src\Application(new Src\Settings([
       'app' => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
       'db' => include $_SERVER['DOCUMENT_ROOT'] . '/config/bd.php',
       'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
   ]));

   //Глобальная функция для доступа к объекту приложения
   if (!function_exists('app')) {
       function app()
       {
           return $GLOBALS['app'];
       }
   }
}

}

