<?php
namespace App\Model;

use Base\AbstractModel;
use Base\Db;

class User extends AbstractModel
{
    // Модель пользователя

    private $userId;
    private $name;
    private $email;
    private $password;
    private $date;

    // Сбор данных пользователя
    public function __construct($data = [])
    {
        if ($data) {
            $this->userId = $data['user_id'];
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->date = $data['date'];
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        echo $this->name;
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    // Определение пользователя как админа
    public function isAdmin(): bool
    {
        return in_array($this->userId, ADMIN_ID);
    }

    // Сохранение пользователя в бд
    public function save()
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO users (`name`, `email`, `date`, `password`) VALUES (:name, :email, NOW(), :password)";
        $db->exec($insert, [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        $id = $db->lastInsertId();
        $this->userId = $id;
        return $id;
    }

    // Данные о пользователе по id
    public static function getById(int $userId): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE user_id = '$userId'";
        $data = $db->fetchOne($select);
        if (!$data) {
            return null;
        }

        return new self($data);
    }

    // Данные о пользователе по email
    public static function getByEmail(string $email): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE `email` = :email";
        $data = $db->fetchOne($select, ['email' => $email]);
        if (!$data) {
            return null;
        }

        return new self($data);
    }

    // Хэширование пароля
    public static function getPasswordHash($password)
    {
        return sha1($password . 'cdso.vkd-l');
    }
}