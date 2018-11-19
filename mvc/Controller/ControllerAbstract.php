<?php
/**
 * Created by PhpStorm.
 * User: Lazar
 * Date: 15.11.2018 г.
 * Time: 21:26 ч.
 */

namespace Controller;


use Core\View\ViewInterface;

class ControllerAbstract
{
    /**
     * @var ViewInterface
     */
    private $view;

    public function __construct(ViewInterface $view)
    {
        $this->view=$view;
    }

    protected function render($model=null)
    {
        $this->view->render($model);
    }

}