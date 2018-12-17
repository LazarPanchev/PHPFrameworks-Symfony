<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 10.12.2018 г.
 * Time: 9:36
 */

namespace AppBundle\Service\Calculator;


class CalculatorService implements CalculatorServiceInterface
{

    public function operate($operator, $leftOperand, $rightOperand)
    {
        switch($operator):
            case "+":
                return $leftOperand + $rightOperand;
            case "-":
                return $leftOperand - $rightOperand;
            case "/":
                return $leftOperand / $rightOperand;
            case "*":
                return $leftOperand * $rightOperand;
        endswitch;

        return -1;
    }
}