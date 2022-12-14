<?php

namespace App\Controller;

use App\Model\Blog;
use Base\AbstractController;
use Base\Db;

class Admin extends AbstractController
{
    // Проверка пользователя на права Админа
    public function preDispatch()
    {
        parent::preDispatch();
        if (!$this->user || !$this->user->isAdmin()) {
            $this->redirect('/');
        }
    }

    // Удаление сообщения
    public function deleteAction()
    {
        $postId = (int)$_GET['id'];
        Blog::deleteByPostId($postId);
        $this->redirect('/blog');
    }

}