<?php
/**
 * PHP version 7.1
 * @author BLU <dev@etna-alternance.net>
 */

declare(strict_types=1);

namespace ETNA\Doctrine\Services;

use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subcriber permettant l'ajout de headers
 * contenant les informations des queries
 * effectuées.
 */
class EtnaDoctrineService implements EventSubscriberInterface
{
    /**
     * L'instance doctrine passée en paramètre du service
     * Utilisée pour ajouter les informations
     * concernant les queries aux headers.
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * L'object DebugStack doctrine
     * https://www.doctrine-project.org/api/dbal/2.7/Doctrine/DBAL/Logging/DebugStack.html
     * Permettant d'enregistrer toutes les infos concernant les queries effectuées lors d'un
     * Appel API.
     *
     * @var DebugStack
     */
    private $debug;

    /**
     * Undocumented function.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Subscriber sur les Response API.
     * Cette fonction récupère les informations
     * Enregistrées dans l'object Debug et les intégres aux headers.
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $debug = $this->debug;

        $response = $event->getResponse();
        $request  = $event->getRequest();

        $string_queries = json_encode($debug->queries) ?: '';
        $nb_queries     = \count($debug->queries);

        $response->headers->set('X-ORM-Profiler-Route', $request->getPathInfo());
        $response->headers->set('X-ORM-Profiler-Count', "{$nb_queries}");
        $response->headers->set('X-ORM-Profiler-Queries', $string_queries);
    }

    /**
     * Subscriber sur les Appels controller
     * reset la debug stack et la rajoute à l'entityManager.
     */
    public function onKernelController(): void
    {
        $this->debug = new DebugStack();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($this->debug);
    }

    /**
     * Methode Nécessaire aux EventSubscriberInterface
     * Désignant tous les events auquel cette classe
     * Subscribe.
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE   => 'onKernelResponse',
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
