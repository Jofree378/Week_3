<?php
namespace App\Controller;

use App\Model\User as UserModel;
use Base\AbstractController;
use Base\View;

class User extends AbstractController
{

    // Вход в аккаунт с проверками
    function authAction()
    {
        $email = htmlspecialchars(trim($_POST['email']));

        if ($email) {
            $password = htmlspecialchars($_POST['password']);
            $user = UserModel::getByEmail($email);
            if (!$user) {
                $this->view->assign('error', 'Пользователь не найден');
            }

            if($user) {
                if ($user['password'] != UserModel::getPasswordHash($password)) {
                    $this->view->assign('error', 'Пользователь не найден');
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $this->redirect('/blog/index');
                }
            }
        }

        return $this->view->render('User/auth.phtml', ['user' => UserModel::getById((int)$_GET['id'])]);
    }

    // Регистрация нового пользователя
    function registerAction()
    {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirmPassword = htmlspecialchars(trim($_POST['password-confirm']));


        // Проверка
        $register = true;
        if(isset($_POST['email'])) {
            if(!$email) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести email');
            } elseif (!$password) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести пароль');
            } elseif ($password != $confirmPassword) {
                $register = false;
                $this->view->assign('error', 'Пароли не совпадают');
            } elseif (mb_strlen($password) < 4) {
                $register = false;
                $this->view->assign('error', 'Пароль должен содержать минимум 4 символа');
            }

            $userByEmail = UserModel::getByEmail($email);
            if($userByEmail) {
                $register = false;
                $this->view->assign('error', 'Пользователь с таким email уже существует');
            }

            // Регистрация
            if ($register) {
                $user = new UserModel();
                $user['name'] = $name;
                $user['email'] = $email;
                $user['password'] = UserModel::getPasswordHash($password);
                $user->save();

                $_SESSION['user_id'] = $user['id'];
                $this->setUser($user);

                $this->redirect('/blog/index');
            }
        }

         return $this->view->render('User/register.phtml', ['user' => UserModel::getById((int) $_GET['id'])]);
    }

    // Отображение через Twig
    public function twigRegisterAction()
    {
        $this->view->setRenderType(View::RENDER_TYPE_TWIG);
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirmPassword = htmlspecialchars(trim($_POST['password-confirm']));


        // Проверка
        $register = true;
        if(isset($_POST['email'])) {
            if (!$email) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести email');
            } elseif (!$password) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести пароль');
            } elseif ($password != $confirmPassword) {
                $register = false;
                $this->view->assign('error', 'Пароли не совпадают');
            } elseif (mb_strlen($password) < 4) {
                $register = false;
                $this->view->assign('error', 'Пароль должен содержать минимум 4 символа');
            }

            $userByEmail = UserModel::getByEmail($email);
            if ($userByEmail) {
                $register = false;
                $this->view->assign('error', 'Пользователь с таким email уже существует');
            }

            // Регистрация
            if ($register) {
                $user = new UserModel();
                $user->setName($name)->setEmail($email)->setPassword(UserModel::getPasswordHash($password));

                $user->save();

                $_SESSION['user_id'] = $user->getUserId();
                $this->setUser($user);

                $this->redirect('/blog/twigIndex');
            }
        }
        return $this->view->render('User/register.twig', ['title' => 'Регистрация']);
    }

    public function twigAuthAction()
    {
        $this->view->setRenderType(View::RENDER_TYPE_TWIG);
        $email = htmlspecialchars(trim($_POST['email']));

        if ($email) {
            $password = htmlspecialchars($_POST['password']);

            $user = UserModel::getByEmail($email);
            if (!$user) {
                $this->view->assign('error', 'Пользователь не найден');
            }

            if($user) {
                if ($user->getPassword() != UserModel::getPasswordHash($password)) {
                    $this->view->assign('error', 'Пользователь не найден');
                } else {
                    $_SESSION['user_id'] = $user->getUserId();
                    $this->redirect('/blog/twigIndex');
                }
            }
        }
        return $this->view->render('User/auth.twig', ['title' => 'Вход']);
    }




    // Переход на страницу войти из страницы регистрации
    public function authRedirectAction()
    {
        $this->redirect('/user/auth');
    }

    // Переход с Twig
    public function authRedirectTwigAction()
    {
        $this->redirect('/user/twigAuth');
    }


    // Выход из аккаунта на страницу регистрации
    public function logoutAction()
    {
        $_SESSION = [];
        session_destroy();

        $this->redirect('/user/register');
    }

    public function twigLogoutAction()
    {
        $_SESSION = [];
        session_destroy();

        $this->redirect('/user/twigRegister');
    }
}