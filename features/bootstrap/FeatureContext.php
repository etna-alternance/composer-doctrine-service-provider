<?php

use ETNA\FeatureContext\BaseContext;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends BaseContext
{
    /**
     * @Given je veux récupérer un service :sevice_name
     */
    public function jeVeuxRecupererUnService($service_name)
    {
        $container = $this->getContainer();

        $this->getContext("ETNA\FeatureContext\ExceptionContainerContext")->try(
            function () use ($container, $service_name) {
                $container->get($service_name);
            }
        );
    }
}
