<?php

namespace ETNA\Doctrine\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class TestDumpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:dump')
            ->setDescription('Dump all sql file, in test database')
            ->addOption('files', './features/data/test*.sql', InputOption::VALUE_OPTIONAL, 'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $name = $input->getArgument('name');
        // if ($name) {
        //     $text = 'Hello '.$name;
        // } else {
        //     $text = 'Hello';
        // }
        // echo json_encode(glob("./features/data/test*.sql"));die;
        $files = glob($input->getOption('files'));

        foreach($files as $file) {
            $cat   = escapeshellcmd("cat {$file}");
            $mysql = escapeshellcmd("mysql -NrB -u root -h 127.0.0.1 --password= test_doctrine_provider");
            $cmd   = "{$cat} | {$mysql}";
            passthru($cmd);
        }

        $output->writeln("WEHS");
    }
}
