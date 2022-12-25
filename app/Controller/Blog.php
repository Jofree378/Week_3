<?php

namespace App\Controller;

use \App\Model\Blog as BlogModel;
use Base\AbstractController;
use Base\View;

class Blog extends AbstractController
{
    // Добавление сообщения и отображение блога
    function indexAction()
    {
        $message = htmlspecialchars($_POST['message']);
        $userId = $_SESSION['user_id'];
        $pathImage = ['../images/', mt_rand(1, 100000), '.jpg'];
        $idImage = $pathImage[1];

        $post = new BlogModel();
        if ($message) {
            $post['message'] = $message;
            $post['user_id'] = $userId;
            $post['send_at'] = date('Y-m-d H:i:s');
            if(!empty($_FILES['userFile']['tmp_name'])) {
                $post['image'] = implode($pathImage);
                $fileContent = file_get_contents($_FILES['userFile']['tmp_name']);
                file_put_contents($post['image'], $fileContent);
            } else {
                $post['image'] = 1;
            }
            $post->save();
        }

        $posts = $post::getPosts(20);
        if (!$posts) {
            $this->view->assign('error', 'Постов пока нет');
        }

        $this->setPost($post);

        if (!$this->user) {
           $this->redirect('/user/register');
        }

        return $this->view->render('blog/index.phtml', [
            'posts' => $posts,
            'user' => $this->user,
            'userEmail' => $this->user['email'],
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
        $fileId = $_GET['post_id'];
        $image = file_get_contents($fileId);
        echo $image;
    }


}
