<?php
namespace Base;

use App\Controller\Blog;
use App\Controller\User;

class Application
{
    private $route;
    /** @var AbstractController*/
    private $controller;
    private $actionName;

    public function __construct()
    {
        $this->route = new Route();
    }

    // Начало сессии подключение данных пользователя, сообщений и вывод ошибок
    public function run()
    {
        try {
            session_start();

            $this->addRoutes();
            $this->initController();
            $this->initAction();

            $view = new View();
            $this->controller->setView($view);
            $this->initUser();
            $this->controller->preDispatch();

            $content = $this->controller->{$this->actionName}();
            echo $content;

        } catch (RedirectException $e) {
            header('Location: ' . $e->getUrl());
            die;
        } catch (RouteException $e) {
            header('HTTP/1.0 404 Not Found');
        }

    }

    // Инициализация пользователя
    public function initUser()
    {
        $id = $_SESSION['user_id'];
        if ($id) {
            $user = \App\Model\User::getById($id);
            if ($user) {
                $this->controller->setUser($user);
            }
        }
    }

    // Добавление роута
    private function addRoutes()
    {
        $this->route->addRoute('/blog', Blog::class, 'index');
    }

    // Инициализация контроллера
    private function initController()
    {
        $controllerName = $this->route->getControllerName();
        if (!class_exists($controllerName)) {
            throw new RouteException('Can`t find controller' . $controllerName);
        }
        $this->controller = new $controllerName;
    }

    // Инициализация метода
    private function initAction()
    {
        $actionName = $this->route->getActionName();
        if (!method_exists($this->controller, $actionName)) {
            throw new RouteException('Action ' . $actionName . ' not found in ' . get_class($this->controller));
        }
        $this->actionName = $actionName;
    }


}
