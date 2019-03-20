<?php

use ETNA\FeatureContext\BaseContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Behat\Tester\Exception\PendingException;
use ETNA\Doctrine\Services\EtnaDoctrineService;
use function GuzzleHttp\json_encode;
/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends BaseContext
{
    static private $max_queries;
    static private $query_count = 0;

    public function __construct($max_queries)
    {
        self::$max_queries = $max_queries;
    }

    public function checkMaxQueries($response)
    {
        $actual_queries_count = $response["headers"]["x-orm-profiler-count"];
        self::$query_count   += $actual_queries_count;
        if ($actual_queries_count >= self::$max_queries) {
            throw new PendingException("Too many SQL queries ({$response["headers"]["x-orm-profiler-count"]})");
        }
    }

    /**
     * @Given /j\'ai le droit de faire (\d+) requetes SQL$/
     */
    public function jaiLeDroitDeFaireRequetesSql($nb)
    {
        self::$max_queries = $nb;
    }

    /**
    * @AfterSuite
    */
    public static function showQueryCount()
    {
        echo "\n# total queries : ", self::$query_count, "\n";
    }

    //  /**
    //  * @BeforeScenario
    //  */
    // public function beginTransaction()
    // {
    //     $em = $this->getContainer()->get('doctrine')->getManager();
    //     $em->getConnection()->beginTransaction();
    //     $em->clear();
    // }

    // /**
    //  * @AfterScenario
    //  */
    // public function rollback()
    // {
    //     $em = $this->getContainer()->get('doctrine')->getManager();
    //     $em->getConnection()->rollback();
    // }
}
