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
            ->addOption('user', 'u', InputOption::VALUE_OPTIONAL, 'user for database connection', 'root')
            ->addOption('password', 'pwd', InputOption::VALUE_OPTIONAL, 'password for database connection')
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'host address of the database', '127.0.0.1')
            ->addOption('files', 'f', InputOption::VALUE_OPTIONAL, 'directory where sql files are stored', './features/data/test*.sql')
        ;
    }

    protected function execute(InputInterface $input)
    {
        $files    = glob($input->getOption('files'));
        $user     = $input->getOption('user');
        $password = $input->getOption('password');
        $host     = $input->getOption('host');

        foreach($files as $file) {
            $cat   = escapeshellcmd("cat {$file}");
            $mysql = escapeshellcmd("mysql -NrB -u {$user} -h {$host} --password={$password} test_doctrine_provider");
            $cmd   = "{$cat} | {$mysql}";
            passthru($cmd);
        }
    }
}
