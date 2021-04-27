<?php

namespace AHT\ModuleHelloWorld\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleHelloWorldCommand extends Command

{
    const INPUT_KEY_EXTENDED = 'extended';
    protected function configure()
    {
        $options = [
            new InputOption(
                self::INPUT_KEY_EXTENDED,
                null,
                InputOption::VALUE_NONE,
                'Get extended info'
            )
        ];

        $this->setName('modulehelloworld:info')->setDescription('Get info about installation')
            ->setDefinition($options);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>writeln surrounded by error tag</error>');
        $output->writeln('<comment>writeln surrounded by comment tag</comment>');
        $output->writeln('<info>writeln surrounded by info </info>');
        $output->writeln('<question>writeln surrounded by info tag</question>');
        $output->writeln('writeln with normal output');
        if ($input->getOption(self::INPUT_KEY_EXTENDED)) {
            $output->writeln('');
            $output->writeln('<info>Extended parameter is given</info>');
        }
        $output->writeln('');
    }
}