<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 10.12.2018 г.
 * Time: 10:22
 */

namespace Tests\AppBundle\Service;



use AppBundle\Service\Calculator\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Tests\KernelTest;

class CalculatorServiceTests extends KernelTestCase
{
    private $container;

    public function __construct()
    {
        parent::__construct();
        $kernel = self::bootKernel();
        $this->container = $kernel->getContainer();

    }


    //what we test, in which conditions we test it and what we expect
    public function testOperate_add_positiveIntegers_expectPositiveSum()
    {
        $calcService = $this->container->get(CalculatorService::class);
        $result = $calcService->operate("+",6,9);
        $this->assertEquals(15, $result);
    }

}