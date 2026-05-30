<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Model\User;

// Эмуляция xdebug_get_headers
if (!function_exists('xdebug_get_headers')) {
    function xdebug_get_headers(): array {
        return headers_list();
    }
}

class SiteTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testSignup(string $httpMethod, array $userData, string $expectedType, $expectedValue): void
    {
        // Мокаем Request с правильными методами
        $request = $this->createMock(\Src\Request::class);
        $request->method('all')->willReturn($userData);
        $request->method('get')->willReturnCallback(fn($key) => $userData[$key] ?? null);
        $request->method = $httpMethod;

        // Для теста с занятым логином: создаём "занятого" пользователя
        $busyLogin = null;
        if ($expectedType === 'validation_error' && str_contains($expectedValue ?? '', 'уникально')) {
            $busyLogin = 'busy_' . uniqid();
            User::create([
                'name' => 'Busy',
                'user_name' => $busyLogin,
                'password' => 'pass',
                'role' => 'user'
            ]);
            $userData['user_name'] = $busyLogin;
            $request->method('all')->willReturn($userData);
            $request->method('get')->willReturnCallback(fn($key) => $userData[$key] ?? null);
        }

        // Мокаем редирект, чтобы не отправлять реальные заголовки
        $routeMock = $this->getMockBuilder(\Src\Route::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['redirect'])
            ->getMock();
        $routeMock->expects($this->any())
            ->method('redirect')
            ->willReturnCallback(fn($url) => $GLOBALS['last_redirect'] = $url);

        $GLOBALS['app']->route = $routeMock;

        // Захватываем вывод контроллера
        ob_start();
        $result = (new \Controller\Site())->signup($request);
        $output = ob_get_clean();
        $output = $output ?: (string)$result;

        // Проверяем результат
        switch ($expectedType) {
            case 'empty_form':
                $this->assertStringContainsString('Регистрация', $output);
                break;
            case 'validation_error':
                $this->assertStringContainsString($expectedValue, $output);
                break;
            case 'redirect':
                $this->assertNotEmpty($GLOBALS['last_redirect'] ?? '');
                $this->assertStringContainsString($expectedValue, $GLOBALS['last_redirect']);
                $this->assertTrue(User::where('user_name', $userData['user_name'])->exists());
                break;
        }
    }

    public function additionProvider(): array
    {
        return [
            'GET empty form' => [
                'GET',
                ['name' => '', 'user_name' => '', 'password' => ''],
                'empty_form',
                null
            ],
            'POST empty fields' => [
                'POST',
                ['name' => '', 'user_name' => '', 'password' => ''],
                'validation_error',
                '{"name":["Поле name пусто"],"user_name":["Поле user name пусто"],"password":["Поле password пусто"]}'
            ],
            'POST duplicate username' => [
                'POST',
                ['name' => 'admin', 'user_name' => 'REPLACE_ME', 'password' => 'admin'],
                'validation_error',
                '{"user_name":["Поле user name должно быть уникально"]}'
            ],
            'POST success registration' => [
                'POST',
                ['name' => 'admin', 'user_name' => 'test_' . uniqid(), 'password' => 'admin'],
                'redirect',
                '/hello'  // Убедитесь, что в config/path.php: 'root' => ''
            ],
        ];
    }

    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = '/var/www/html';
        $GLOBALS['app'] = new \Src\Application(new \Src\Settings([
            'app'  => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',
            'db'   => include $_SERVER['DOCUMENT_ROOT'] . '/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
        ]));
        $GLOBALS['last_redirect'] = null;

        if (!function_exists('app')) {
            function app() { return $GLOBALS['app']; }
        }
    }

    protected function tearDown(): void
    {
        User::where('user_name', 'like', 'test_%')->delete();
        User::where('user_name', 'like', 'busy_%')->delete();
        User::where('user_name', '')->delete(); // Очищаем пустые логины
        $GLOBALS['last_redirect'] = null;
        parent::tearDown();
    }
}