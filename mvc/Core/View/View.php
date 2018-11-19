<?php


namespace Core\View;


class View implements ViewInterface
{
    const VIEW_PATH='View/';
    const EXTENSION_PATH = '.php';

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    public function __construct(string $controllerName,string $actionName)
    {
        $this->controllerName=$controllerName;
        $this->actionName=$actionName;
    }

    public function render($model=null)
    {
        require_once self::VIEW_PATH .
            $this->controllerName . '/' .
            $this->actionName .
            self::EXTENSION_PATH;
    }

}