<?php

namespace Frc\Satis\Console\Command;

use Frc\Satis\Builder\JsonBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
    protected static $defaultName = 'build';

    protected function configure()
    {
        $this
            ->addOption('from', null, InputOption::VALUE_REQUIRED)
            ->addOption('external', null, InputOption::VALUE_REQUIRED)
            ->addOption('output', null, InputOption::VALUE_REQUIRED)
            ->addOption('name', null, InputOption::VALUE_REQUIRED)
            ->addOption('homepage', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        (new JsonBuilder(getcwd()))
            ->external($input->getOption('external'))
            ->from($input->getOption('from'))
            ->name($input->getOption('name'))
            ->homepage($input->getOption('homepage'))
            ->save($input->getOption('output'));
    }
}
