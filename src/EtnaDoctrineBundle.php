<?php
/**
 * PHP version 7.1
 * @author BLU <dev@etna-alternance.net>
 */

declare(strict_types=1);

namespace ETNA\Doctrine;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Classe mère du Doctrine Bundle ETNA.
 */
class EtnaDoctrineBundle extends Bundle
{
    /**
     * Register la commande test:dump, permettant de refresh
     * la db de test de l'application.
     *
     * @param Application $application L'application symfony
     */
    public function registerCommands(Application $application): void
    {
        $application->add(new Command\TestDumpCommand());
    }
}
