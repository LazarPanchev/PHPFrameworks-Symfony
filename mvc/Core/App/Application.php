<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 16.11.2018 г.
 * Time: 8:17
 */

namespace Core\App;


use Core\Request\Request;
use Core\View\ViewInterface;

class Application
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request=$request;
    }

    /**
     * @throws \Exception
     */
    public function run(){
        $fullControllerName=$this->request->getFullControllerName();

        $controller= new $fullControllerName($this->request->getView());

        if(!is_callable([$controller,$this->request->getActionName()])){
            throw new \Exception('Action not exists');
        }

        $params=[];
        $paramObj=null;
        $actionData = new \ReflectionMethod($fullControllerName,$this->request->getActionName());
        $actionParams=$actionData->getParameters();

        foreach ($actionParams as $actionParam){
            $class = $actionParam->getClass();
            if($class){
                $className=$class->getName();
                $paramObj= new $className();

                $propertiesInfo=new \ReflectionClass($paramObj);

                foreach ($propertiesInfo->getProperties() as $property){

                    $propertyName = $property->getName();
                    if(array_key_exists($propertyName,$_POST)){
                        $setter='set' . implode('',
                                array_map(function ($el){
                                    return ucfirst($el);
                                },explode('_',$propertyName)));
                        $paramObj->$setter($_POST[$propertyName]);

                    }
                }

            }
            $params[]=$paramObj;
        }
        var_dump($params);
        exit();

        call_user_func_array([$controller,$this->request->getActionName()],   //dynamically send the params depends of how many elements we have in the array params
            $params);

    }

}