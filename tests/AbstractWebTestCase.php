<?php


namespace App\Tests;

use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractWebTestCase extends WebTestCase
{
    /**
     * @var array
     */
    private static $metaData;

    /**
     * @var ReferenceRepository
     */
    private static $fixturesReferenceRepository;

    /**
     * To know if setUp has to be run or not in the current class.
     *
     * @var string
     */
    private static $isSetUp;

    /**
     * If true, execute setUp to init Database for each test.
     *
     * @var bool
     */
    private $setUpForEachTestEnabled;

    /**
     * WebTestCase constructor.
     *
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->setUpForEachTestEnabled = false;
    }

    /**
     * Get fixturesReferenceRepository who contain all fixtures references.
     *
     * @return ReferenceRepository
     */
    protected static function getFRR(): ReferenceRepository
    {
        return self::$fixturesReferenceRepository;
    }

    /**
     * Do setUpDatabasePostgresql.
     *
     * @param Connection $doctrineCon
     *
     * @throws DBALException
     */
    protected static function setUpDatabasePostgresql(Connection $doctrineCon): void
    {
        /** @var array|string[] $schemas */
        $schemas = $doctrineCon->query(
            '
            SELECT schema_name
            FROM information_schema.schemata 
            WHERE schema_name NOT LIKE \'pg_%\' AND schema_name != \'public\' AND schema_name != \'information_schema\';'
        )->fetchAll();
        foreach ($schemas as $schema) {
            $doctrineCon->query('DROP SCHEMA ' . $schema['schema_name'] . ' CASCADE;');
        }
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     * @param int $invalidBehavior The behavior when the service does not exist
     *
     * @return object The associated service
     *
     * @throws ServiceNotFoundException          When the service is not defined
     *
     * @throws ServiceCircularReferenceException When a circular reference is detected
     * @see Reference
     */
    public function get($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        return $this->getContainer()->get($id, $invalidBehavior);
    }

    /**
     * {@inheritdoc}
     * @throws DBALException
     */
    protected function setUp(): void
    {
        parent::setUp();

        if ($this->setUpForEachTestEnabled || static::class !== self::$isSetUp) {
            $this->setUpBuild();
            $this->setUpAcl();
            self::$isSetUp = static::class;
        }
    }

    /**
     * {@inheritdoc}
     * @throws DBALException
     * @throws ToolsException
     */
    public function setUpBuild(): void
    {
        $doctrineCon = $this->getContainer()->get('doctrine.dbal.default_connection');

        $params = $doctrineCon->getParams();
        $dbName = $params['dbname'];
        unset($params['dbname'], $params['path'], $params['url']);
        $tmpConnection = DriverManager::getConnection($params);
        $doctrineCon->close();
        $tmpConnection->getSchemaManager()->dropAndCreateDatabase($dbName);
        $tmpConnection->close();
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->resetManager();
        if (!self::$metaData) {
            self::$metaData = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        if (self::$metaData) {
            $schemaTool->createSchema(self::$metaData);
        }

        $fixtures = static::getFixtures();
        self::$fixturesReferenceRepository = $this->loadFixtures($fixtures)->getReferenceRepository();
    }

    /**
     * Abstract method to get all fixtures needed for the test.
     */
    abstract public static function getFixtures(): array;

    /**
     * Init ACL.
     */
    protected function setUpAcl(): void
    {
        $this->runCommand('sonata:admin:setup-acl');
    }

    /**
     * Do tearDown.
     */
    protected function tearDown(): void
    {
        $this->getContainer()->get('doctrine.orm.entity_manager')->getConnection()->close();

        parent::tearDown();
    }

    /**
     * Gets a named entity manager.
     *
     * @param string $name The entity manager name (null for the default one)
     *
     * @return ObjectManager|EntityManagerInterface
     */
    protected function getEntityManager(string $name = null): EntityManagerInterface
    {
        return $this->getDoctrine()->getManager($name);
    }

    /**
     * Get Doctrine.
     *
     * @return RegistryInterface
     */
    protected function getDoctrine(): RegistryInterface
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @param UserInterface $user
     * @param string $firewallName
     *
     * @return $this
     */
    protected function tokenAs(UserInterface $user, string $firewallName)
    {
        $token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());
        $this->getContainer()->get('security.token_storage')->setToken($token);

        return $this;
    }
}