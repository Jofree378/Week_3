<?php

namespace App\Controller;

use \App\Model\Blog as BlogModel;
use Base\AbstractController;
use Base\Db;
use Base\View;

class Blog extends AbstractController
{
    // Добавление сообщения и отображение блога
    function indexAction()
    {
        $message = htmlspecialchars($_POST['message']);
        $userId = $_SESSION['user_id'];
        $post = new BlogModel();
        if ($message) {
            $post->setMessage($message)->setUserId($userId);

            $post->savePost();
        }
        $posts = $post::getPosts(20);
        if (!$posts) {
            $this->view->assign('error', 'Постов пока нет');
        }
        $postByUsers = $post->getUserById();


        $this->setPost($post);

        if (!$this->user) {
            $this->redirect('/user/register');
        }

        return $this->view->render('blog/index.phtml', ['postByUsers' => $postByUsers,
            'posts' => $posts,
            'user' => $this->user->getUserId(),
            'userEmail' => $this->user->getEmail()
        ]);
    }

    public function twigIndexAction()
    {
        $this->view->setRenderType(View::RENDER_TYPE_TWIG);
        $message = htmlspecialchars($_POST['message']);
        $userId = $_SESSION['user_id'];
        $post = new BlogModel();
        if ($message) {
            $post->setMessage($message)->setUserId($userId);

            $post->savePost();
        }
        $posts = $post::getPosts(20);
        if (!$posts) {
            $this->view->assign('error', 'Постов пока нет');
        }
        $postByUsers = $post->getUserById();


        $this->setPost($post);

        if (!$this->user) {
            $this->redirect('/user/twigRegister');
        }

        return $this->view->render('Blog/index.twig', ['postByUsers' => $postByUsers,
            'posts' => $posts,
            'user' => $this->user->getUserId(),
            'userEmail' => $this->user->getEmail()
        ]);
    }


    // Загрузка изображений
    public function imageAction()
    {
        $fileId = (int)$_GET['post_id'];
        $image = file_get_contents('../images/' . $fileId . '.png');
        echo $image;
    }


}
