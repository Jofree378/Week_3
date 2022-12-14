<?php
namespace App\Model;

use Base\AbstractModel;
use Base\Db;

class Blog extends AbstractModel
{
    // Модель сообщения

    private $postId;
    private $userId;
    private $datetime;
    private $message;


    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param mixed $postId
     */
    public function setPostId($postId): self
    {
        $this->postId = $postId;
        return $this;
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
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime(string $datetime): self
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }


    // Добавление сообщения в бд
    public function savePost()
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO posts (`user_id`, `datetime`, `message`) VALUES (:userId, NOW(), :message)";
        $db->exec($insert, [
            'userId' => $this->userId,
            'message' => $this->message
        ]);

        $id = $db->lastInsertId();
        $this->postId = $id;

        if(!empty($_FILES['userFile']['tmp_name'])) {
            $fileContent = file_get_contents($_FILES['userFile']['tmp_name']);
            file_put_contents('../../images/' . $id . '.png', $fileContent);
        }

        return $id;
    }

    // Получение последних n сообщений
    public static function getPosts(int $limit): ?array
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $limit";
        $dataPost = $db->fetchAll($select);
        if (!$dataPost) {
            return null;
        }

        return $dataPost;
    }

    // Выод сообщений конкретного пользователя через api
    public static function getUserPosts(int $userId, int $limit): ?array
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM posts WHERE user_id = $userId LIMIT $limit";
        $dataPost = $db->fetchAll($select);
        if (!$dataPost) {
            return null;
        }

        $messages = [];
        foreach ($dataPost as $elem) {
            $posts = new self($elem);
            $posts->postId = $elem['post_id'];
            $posts->userId = $elem['user_id'];
            $posts->datetime = $elem['datetime'];
            $posts->message= $elem['message'];
            $messages[] = $posts;
        }

        return $messages;
    }

    // Получения массива пользователя
    public static function getUserByPost($userIdInStr): ?array
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE user_id IN($userIdInStr)";
        $usersById = $db->fetchAll($select);
        if (!$usersById) {
            return null;
        }

        return $usersById;
    }

    // Получение массива пользователей по id
    public function getUserById() :array
    {
        $posts = $this::getPosts(20);
        $postsByUserId = array_column($posts, 'user_id');
        $userIdInStr = implode(',', array_unique($postsByUserId));
        $users = $this::getUserByPost($userIdInStr);
        return array_combine(array_column($users, 'user_id'), $users);
    }

    // Функция удаленмия сообщения пользователя
    public static function deleteByPostId($postId)
    {
        $db = Db::getInstance();
        $delete = "DELETE FROM posts WHERE post_id = :postId LIMIT 1";
        $ret = $db->exec($delete, ['postId' => $postId]);
        if(!$ret) {
            return null;
        }
        return $ret;
    }


    // Получение данных для api метода
    public function getData()
    {
        return ['post_id' => $this->postId,
            'user_id' => $this->userId,
            'datetime' => $this->datetime,
            'message' => $this->message];
    }
}