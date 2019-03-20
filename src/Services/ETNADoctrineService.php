<?php

namespace ETNA\Doctrine\Services;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Logging\LoggerChain;


class EtnaDoctrineService implements EventSubscriberInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $debug = $this->debug;

        $response = $event->getResponse();
        $request  = $event->getRequest();

        $queries = $debug->queries;

        $response->headers->set("X-ORM-Profiler-Route", $request->getPathInfo());
        $response->headers->set("X-ORM-Profiler-Count", count($queries));
        $response->headers->set("X-ORM-Profiler-Queries", json_encode($queries));
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->debug = new DebugStack();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($this->debug);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}
