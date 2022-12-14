<?php
namespace Base;

use Exception;

class RedirectException extends Exception
{
    // Обработка ошибок и настройка переходов
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}