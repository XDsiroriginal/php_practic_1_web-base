<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'user_id';

    public $timestamps = false;
    protected $fillable = [
        'name',
        'user_name',
        'password',
        'role',
        'department_id',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('user_id', $id)->first();
    }

    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->user_id;
    }

    //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where(['user_name' => $credentials['user_name'],
            'password' => md5($credentials['password'])])->first();
    }
}
