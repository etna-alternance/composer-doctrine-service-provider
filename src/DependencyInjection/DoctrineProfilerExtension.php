<?php

namespace ETNA\Doctrine\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Doctrine\DBAL\Driver\Connection;


class DoctrineProfilerExtension extends Extension {

    public function load(Connection $doctrine_connexion, EntityManagerInterface $entityManager): void {
        $platform = $doctrine_connexion->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        $configuration = $entityManager->getConfiguration();

        $configuration->addCustomStringFunction('MD5',  'DoctrineExtensions\Query\Mysql\Md5');
        $configuration->addCustomStringFunction('SHA1', 'DoctrineExtensions\Query\Mysql\Sha1');
        $configuration->addCustomStringFunction('SHA2', 'DoctrineExtensions\Query\Mysql\Sha2');

        $configuration->addCustomNumericFunction('RAND',  'DoctrineExtensions\Query\Mysql\Rand');
        $configuration->addCustomNumericFunction('ROUND', 'DoctrineExtensions\Query\Mysql\Round');

        $configuration->addCustomDatetimeFunction('DATE',       'DoctrineExtensions\Query\Mysql\Date');
        $configuration->addCustomDatetimeFunction('DATEDIFF',   'DoctrineExtensions\Query\Mysql\DateDiff');
        $configuration->addCustomDatetimeFunction('DATEADD',    'DoctrineExtensions\Query\Mysql\DateAdd');
        $configuration->addCustomDatetimeFunction('DATEFORMAT', 'DoctrineExtensions\Query\Mysql\DateFormat');
        $configuration->addCustomDatetimeFunction('HOUR',       'DoctrineExtensions\Query\Mysql\Hour');
        $configuration->addCustomDatetimeFunction('DAY',        'DoctrineExtensions\Query\Mysql\Day');
        $configuration->addCustomDatetimeFunction('WEEK',       'DoctrineExtensions\Query\Mysql\Week');
        $configuration->addCustomDatetimeFunction('MONTH',      'DoctrineExtensions\Query\Mysql\Month');
        $configuration->addCustomDatetimeFunction('YEAR',       'DoctrineExtensions\Query\Mysql\Year');
    }
}
