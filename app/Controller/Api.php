<?php
namespace App\Controller;

use App\Model\Blog;
use Base\AbstractController;

class Api extends AbstractController
{
    // Вывод сообщений конкретного пользователя
    public function getUserPostsAction()
    {
        $userId = (int) $_GET['user_id'] ?? 0;
        if(!$userId) {
            return $this->response(['error' => 'Не выбран пользователь или такого пользователя не существует']);
        }
        $posts = Blog::getUserPosts($userId, 20);
        if(!$posts) {
            return $this->response(['error' => 'Сообщений нет']);
        }

        $data = array_map(function (Blog $message) {
            return $message->getData();
        }, $posts);

        return $this->response(['posts' => $data]);
    }

    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}