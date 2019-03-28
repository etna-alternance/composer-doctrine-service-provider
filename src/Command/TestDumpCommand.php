<?php
/**
 * PHP version 7.1
 * @author BLU <dev@etna-alternance.net>
 */

declare(strict_types=1);

namespace ETNA\Doctrine\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Cette classe définie la commande test:dump.
 *
 * Cette commande permet de dump la base de donnée de test de l'application en se basant sur les fichiers
 * se trouvant dans le dossier ./features/data/test*.sql
 */
class TestDumpCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        $this
            ->setName('test:dump')
            ->setDescription('Dump all sql file, in test database')
            ->addOption('user', 'u', InputOption::VALUE_OPTIONAL, 'user for database connection', 'root')
            ->addOption('password', 'pwd', InputOption::VALUE_OPTIONAL, 'password for database connection', '')
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'host address of the database', '127.0.0.1')
            ->addOption(
                'files',
                'f',
                InputOption::VALUE_OPTIONAL,
                'directory where sql files are stored',
                './features/data/test*.sql'
            )
        ;
    }

    /**
     * Execute un dump de la base de donnée de test.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path     = \is_string($input->getOption('files')) ? (string) $input->getOption('files') : '';
        $user     = \is_string($input->getOption('user')) ? (string) $input->getOption('user') : '';
        $password = \is_string($input->getOption('password')) ? (string) $input->getOption('password') : '';
        $host     = \is_string($input->getOption('host')) ? (string) $input->getOption('host') : '';

        $files    = glob($path);

        foreach ($files as $file) {
            $cat   = escapeshellcmd("cat {$file}");
            $mysql = escapeshellcmd("mysql -NrB -u {$user} -h {$host} --password={$password} test_doctrine_provider");
            $cmd   = "{$cat} | {$mysql}";
            passthru($cmd);
        }

        $output->writeln('Database dumped!');

        return null;
    }
}
