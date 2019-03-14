<?php

declare(strict_types=1);

namespace ETNA\Doctrine;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ETNA\Doctrine\DependencyInjection\ETNADoctrineExtension;

class ETNADoctrineBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ETNADoctrineExtension();
    }
}
