<?php
namespace Base;

use App\Controller\Blog as BlogAlias;
use App\Model\Blog;
use App\Model\User;

abstract class AbstractController
{
    /** @var View */
    protected $view;
    /** @var User */
    protected $user;
    /** @var Blog */
    protected $blog;

    // Переход между файлами
    protected function redirect(string $url)
    {
        throw new RedirectException($url);
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function setPost(Blog $blog): void
    {
        $this->blog = $blog;
    }

    public function preDispatch()
    {

    }
}

