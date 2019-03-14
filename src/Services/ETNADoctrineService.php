<?php

namespace ETNA\Doctrine\Services;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;


class ETNADoctrineService implements EventSubscriberInterface {

    private $debug;

    public function __construct(EntityManagerInterface $em)
    {
        //On défini un nouveau débugStack au lancement de l'app
        $this->debug = new DebugStack();
        //Ce debug recéptionnera les infos de doctrine
        $em->getConnection()->getConfiguration()->setSQLLogger($this->debug);
    }

    public function onKernelResponse(FilterResponseEvent $event) {
        $response = $event->getResponse();
        $request  = $event->getRequest();

        $queries = $this->debug->queries;
        $response->headers->set("X-ORM-Profiler-Route", $request->getPathInfo());
        $response->headers->set("X-ORM-Profiler-Count", count($queries));
        $response->headers->set("X-ORM-Profiler-Queries", json_encode($queries));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function getDebugStack() {
        return $this->debug;
    }

    public function setDebugStack(DebugStack $debug) {
        return $this->debug = $debug;
    }
}
