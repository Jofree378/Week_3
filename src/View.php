<?php
namespace Base;

use Twig_Loader_Filesystem;

class View
{
    const RENDER_TYPE_NATIVE = 1;
    const RENDER_TYPE_TWIG = 2;

    // Инициализация .phtml страниц
    private $data = [];
    private $templatePath = '';
    private $renderType;
    private $_twig;

    public function __construct(int $renderType = self::RENDER_TYPE_NATIVE)
    {
        $this->templatePath = PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'app/View';
        $this->renderType = $renderType;
    }

    public function setRenderType($renderType)
    {
        $this->renderType = $renderType;
    }

    // Вывод ошибок
    public function assign(string $email, $value)
    {
        $this->data[$email] = $value;
    }

    // Шаблонизатор Twig
    public function getTwig()
    {
        if (!$this->_twig) {
            $path = trim($this->templatePath, DIRECTORY_SEPARATOR);
            $loader = new Twig_Loader_Filesystem($path);
            $this->_twig = new \Twig_Environment(
                $loader, ['cache' => $path . '_cache', 'auto_reload' => true]
            );
        }

        return $this->_twig;
    }

    // Отрисовка страницы с данными
    public function render(string $tpl, array $data = [])
    {
        switch ($this->renderType) {

            case self::RENDER_TYPE_NATIVE:
                $this->data += $data;
                ob_start();
                include $this->templatePath . DIRECTORY_SEPARATOR . $tpl;
                return ob_get_clean();
                break;

            case self::RENDER_TYPE_TWIG:
                $twig = $this->getTwig();
                ob_start();
                try {
                    echo $twig->render($tpl, $data + ['style' => $this->renderStyle(),
                            'styleBody' => $this->renderStyleBody(),
                            'admin' => ADMIN_ID]);
                } catch (\Exception $e) {
                    trigger_error($e->getMessage());
                };
                return ob_get_clean();
                break;
        }

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
