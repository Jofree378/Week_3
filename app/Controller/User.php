<?php
namespace App\Controller;

use App\Model\User as UserModel;
use Base\AbstractController;

class User extends AbstractController
{
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
                if ($user->getPassword() != UserModel::getPasswordHash($password)) {
                    $this->view->assign('error', 'Пользователь не найден(пароль)');
                } else {
                    $this->redirect('/blog/index');
                }

                $_SESSION['user_id'] = $user->getUserId();
            }
        }

        return $this->view->render('User/auth.phtml', ['user' => UserModel::getById((int) $_GET['id'])]);
    }

    function registerAction()
    {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $confirmPassword = htmlspecialchars(trim($_POST['password-confirm']));

        $register = true;
        if(isset($_POST['email'])) {
            if(!$email) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести email');
            }
            if(!$password) {
                $register = false;
                $this->view->assign('error', 'Необходимо ввести пароль');
            }

            if ($register) {
                $user = new UserModel();
                $user->setName($name)->setEmail($email)->setPassword(UserModel::getPasswordHash($password));

                $user->save();

                $_SESSION['user_id'] = $user->getUserId();
                $this->setUser($user);

                $this->redirect('/blog/index');
            }
        }

         return $this->view->render('User/register.phtml', ['user' => UserModel::getById((int) $_GET['id'])]);
    }

    public function profileAction()
    {
        return $this->view->render('User/profile.phtml', ['user' => UserModel::getById((int) $_GET['id'])]);
    }
}