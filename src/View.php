<?php
namespace Base;

class View
{
    // Инициализация .phtml страниц
    private $data = [];
    private $templatePath = '';

    public function __construct()
    {
        $this->templatePath = PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'app/View';
    }

    // Вывод ошибок
    public function assign(string $email, $value)
    {
        $this->data[$email] = $value;
    }

    // Отрисовка страницы с данными
    public function render(string $tpl, array $data = []): string
    {
        $this->data += $data;
        ob_start();
        include $this->templatePath . DIRECTORY_SEPARATOR . $tpl;
        return ob_get_clean();
    }

    // Отрисовка стилей
    public function renderStyle()
    {
        ob_start();
        include '../app/View/Css/style.css';
        return ob_get_clean();
    }
    public function renderStyleBody()
    {
        ob_start();
        include '../app/View/Css/styleBody.css';
        return ob_get_clean();
    }


    public function __get($varName)
    {
        return $this->data[$varName] ?? null;
    }

}
