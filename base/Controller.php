<?php
namespace Base;


abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $view = new View();
        $this->setView($view->setTemplatePath(__DIR__ . '/../app/view'));
    }

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
