<?php
namespace Base;


abstract class Controller
{
    protected $view;

    public function setView(View $view)
    {
        $this->view = $view;
    }

    protected function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }

    protected function isFieldEmpty($p)
    {
        return (isset($p) && (trim($p) == ''));
    }
}
