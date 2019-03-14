<?php

use ETNA\FeatureContext\BaseContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends BaseContext
{
    static private $max_queries = 10;
    static private $query_count = 0;
    static private $parameters = [];

    public function __construct($max_queries)
    {
        self::$max_queries = $max_queries;
    }

    public function checkMaxQueries($method, $response)
    {
        if (in_array($method, ['GET', 'PUT', 'DELETE']) && $response["headers"]["x-orm-profiler-count"] >= self::$max_queries) {
            $queries = [];
            foreach (json_decode($response["headers"]["x-orm-profiler-queries"]) as $query) {
                $queries[md5($query->sql)]["sql"]      = $query->sql;
                $queries[md5($query->sql)]["params"][] = $query->params;
            }

            throw new PendingException("Too many SQL queries ({$response["headers"]["x-orm-profiler-count"]})");
        }
    }

    /** @BeforeSuite */
    public static function setUpParams(BeforeSuiteScope $scope)
    {
        $environment = $scope->getEnvironment();
        $contexts    = $environment->getContextClassesWithArguments();
        foreach ($contexts as $context => $params) {
            self::$parameters = array_merge(self::$parameters, $params);
        }
    }

    /**
     * @BeforeScenario
     */
    public function resetProfiler()
    {
        // Ouais

        $container = $this->getContainer();
        $debug_stack = $container->get('doctrine.debug_service')->getDebugStack();
        self::$query_count += $debug_stack->currentQuery;
        $debug_stack->queries      = [];
        $debug_stack->currentQuery = 0;
        $container->get('doctrine.debug_service')->setDebugStack($debug_stack);
        self::$max_queries = $this->getParameter("max_queries");
    }

    public function getParameter($name)
    {
        if (false === isset(self::$parameters[$name])) {
            throw new \Exception("Parameter {$name} not set");
        }
        return self::$parameters[$name];
    }

    /**
     * @Given /j\'ai le droit de faire (\d+) requetes SQL$/
     */
    public function jaiLeDroitDeFaireRequetesSql($nb)
    {
        self::$max_queries = $nb;
    }
}
