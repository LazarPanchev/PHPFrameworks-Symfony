<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 9.12.2018 г.
 * Time: 15:41
 */

namespace AppBundle\Command;


use AppBundle\Entity\User;
use AppBundle\Service\User\UserServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DistributeResourcesCommand extends Command
{
    private $userService;

    public function __construct(UserServiceInterface $userService, string $name = null)
    {
        $this->userService = $userService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:resources:distribute');
        $this->addArgument("resources", InputArgument::OPTIONAL,
            "How many resources to distribute?", 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $output->writeln("You have invoked the distribute command");
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $resources = $input->getArgument('resources');
        if(!$resources){
            $question = new Question("How many resources you want to distribute?");
            $questionHelper = new QuestionHelper();
            $resources = $questionHelper->ask($input,$output,$question);
            while (!is_int($resources) && $resources<0){
                $output->writeln("You need to distribute positive resources!");
                $resources = $questionHelper->ask($input,$output,$question);
            }
        }

        $userCount=0;
        foreach ($this->userService->findAll() as $user){
            /** @var User $user */
            $user->setResources($user->getResources()+ $resources);
            $this->userService->save($user);
            $userCount++;
        }

        $output->writeln("You successfully distributed $resources resources to $userCount users.");
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output); // TODO: Change the autogenerated stub
    }

}