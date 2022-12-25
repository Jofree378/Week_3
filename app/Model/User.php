<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Модель пользователя

    public $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    public function posts()
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }


    // Определение пользователя как админа
    public static function isAdmin($id): bool
    {
        return in_array($id, ADMIN_ID);
    }

    // Получение всех пользователей
    public static function getUsers()
    {
        return self::query()->get()->toArray();
    }

    // Данные о пользователе по id
    public static function getById(int $userId)
    {
        return self::query()->where('id', '=', $userId)->first();
    }

    // Данные о пользователе по email
    public static function getByEmail(string $email)
    {
        return self::query()->where('email','=', $email)->first();
    }

    // Хэширование пароля
    public static function getPasswordHash($password)
    {
        return sha1($password . 'cdso.vkd-l');
    }
}