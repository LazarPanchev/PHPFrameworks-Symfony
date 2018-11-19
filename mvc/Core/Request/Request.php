<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 16.11.2018 г.
 * Time: 10:58
 */

namespace Core\Request;


use Core\View\ViewInterface;

class Request
{
    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * @var array
     */
    private $params;

    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * Request constructor.
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     * @param ViewInterface $view
     */
    public function __construct(string $controllerName, string $actionName, array $params, ViewInterface $view)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;
        $this->view = $view;
    }


    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return ViewInterface
     */
    public function getView(): ViewInterface
    {
        return $this->view;
    }

    public function getFullControllerName() :string{
        return 'Controller\\' . ucfirst($this->controllerName) . "Controller";
    }


}