<?php

namespace App\Controller;

use App\Model\User as UserModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Model\Blog;
use Base\AbstractController;


class Admin extends AbstractController
{
    // Проверка пользователя на права Админа
    public function preDispatch()
    {
        parent::preDispatch();
        if (!$this->user || !UserModel::isAdmin($this->user['id'])) {
            $this->redirect('/');
        }
    }

    // Удаление сообщения
    public function deleteAction()
    {
        $postId = (int)$_GET['id'];
        Blog::deleteByPostId($postId);
        $this->redirect('/blog/Index');
    }

    // Миграции
    public function makeTableAction()
    {
        Capsule::schema()->dropIfExists('users');

        Capsule::schema()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unique('email');
            $table->timestamp('created_at');
            $table->string('password');
        });

        Capsule::schema()->dropIfExists('posts');

        Capsule::schema()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->datetime('send_at');
            $table->string('message');
            $table->string('image');
        });
    }


    public function indexAction()
    {
        return $this->view->render('/blog/admin.phtml', ['users' => UserModel::getUsers()]);
    }

    // Изменение пользователя
    public function saveUserAction()
    {
        $id = (int)$_POST['user_id'];
        $name = htmlspecialchars(trim($_POST['user_name']));
        $email = htmlspecialchars(trim($_POST['user_email']));
        $password = htmlspecialchars(trim($_POST['user_password']));


        // Проверка
        $user = UserModel::getById($id);
        $edit = true;
        if (!$email) {
            $edit = false;
            $this->view->assign('error', 'Необходимо ввести email');
        } elseif (!$name) {
            $edit = false;
            $this->view->assign('error', 'Необходимо ввести имя');
        } elseif ($password && mb_strlen($password) < 4) {
            $edit = false;
            $this->view->assign('error', 'Пароль должен содержать минимум 4 символа');
        }

        // Изменение
        if($edit) {
            $user['name'] = $name;
            $user['email'] = $email;
            if ($password) {
                $user['password'] = UserModel::getPasswordHash($password);
            }
            $user->save();
            $this->view->assign('error', 'Изменено');
        }
        return $this->view->render('/blog/admin.phtml', ['users' => UserModel::getUsers()]);

    }

    //Удаление пользователя
    public function deleteUserAction()
    {
        $id = (int)$_GET['id'];
        $user = UserModel::getById($id);
        $user->delete();
        $this->view->assign('error', 'Удален');
        return $this->view->render('/blog/admin.phtml', ['users' => UserModel::getUsers()]);
    }

    // Добавление пользователя
    public function addUserAction()
    {
        $name = htmlspecialchars(trim($_POST['add_name']));
        $email = htmlspecialchars(trim($_POST['add_email']));
        $password = htmlspecialchars(trim($_POST['add_password']));

        // Проверка
        $add = true;
        if(isset($_POST['add_email'])) {
            if(!$email) {
                $add = false;
                $this->view->assign('error', 'Необходимо ввести email');
            } elseif (!$name) {
                $add = false;
                $this->view->assign('error', 'Необходимо ввести имя');
            } elseif (!$password) {
                $add = false;
                $this->view->assign('error', 'Необходимо ввести пароль');
            } elseif (mb_strlen($password) < 4) {
                $add = false;
                $this->view->assign('error', 'Пароль должен содержать минимум 4 символа');
            }

            $userByEmail = UserModel::getByEmail($email);
            if($userByEmail) {
                $add = false;
                $this->view->assign('error', 'Пользователь с таким email уже существует');
            }

            // Регистрация
            if ($add) {
                $user = new UserModel();
                $user['name'] = $name;
                $user['email'] = $email;
                $user['password'] = UserModel::getPasswordHash($password);
                $user->save();
            }
        }

        return $this->view->render('/blog/admin.phtml', ['users' => UserModel::getUsers()]);
    }
}