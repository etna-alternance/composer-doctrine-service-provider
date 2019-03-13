<?php
namespace ETNA\Doctrine\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Doctrine\DBAL\Logging\DebugStack;

class DoctrineOrmExtension extends Extension {

    public function load(): void {
        $doctrine_connection = $this->getDoctrine()->getConnection();
        $doctrine_debug = new DebugStack();
        $doctrine_connection->getConfiguration()->setSQLLogger($doctrine_debug);

        $this->after(
            function (Request $request, Response $response) use ($doctrine_debug) {
                $response->headers->set("X-ORM-Profiler-Route", $request->getPathInfo());
                $response->headers->set("X-ORM-Profiler-Count", count($doctrine_debug->queries));
                $response->headers->set("X-ORM-Profiler-Queries", json_encode($this->queries));
            }
        );
    }
}
