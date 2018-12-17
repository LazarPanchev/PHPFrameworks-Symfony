<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 10.12.2018 г.
 * Time: 9:34
 */

namespace AppBundle\Service\Calculator;


interface CalculatorServiceInterface
{
        public function operate($operator, $leftOperand, $rightOperand);
}