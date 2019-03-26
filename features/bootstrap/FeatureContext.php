<?php

use ETNA\FeatureContext\BaseContext;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

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

    /**
     * @Given la commande ":command_name" devrait exister
     */
    public function laCommandeDevraitExister($command_name)
    {
        $application = new Application($this->getKernel());

        // Ca throw une exception si la commande n'existe pas
        $application->find($command_name);
    }


    /**
     * @Given je lance la commande ":command_name" avec les paramêtres contenus dans :command_params
     * @Given je lance la commande ":command_name"
     */
    public function jeLanceLaCommande($command_name, $command_params = null)
    {
        $application = new Application($this->getKernel());
        $command     = $application->find($command_name);
        $tester      = new CommandTester($command);
        $params      = [];

        if (null !== $command_params) {
            $params = json_decode(file_get_contents($this->requests_path . "/" . $command_params), true);
        }

        $this->tester = $tester;
        $this->getContext("ETNA\FeatureContext\ExceptionContainerContext")->try(
            function () use ($tester, $params) {
                $tester->execute($params);
            }
        );
    }
}
