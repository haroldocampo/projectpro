<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 14/09/2017
 * Time: 10:19 PM
 */

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    /**
     * @var string
     */
    protected $URL = '/api/projects';

    // protected function setUp()
    // {
    //     $kernel = self::bootKernel();
    //     DatabasePrimer::prime(self::$kernel);
        
    //     $this->em = $kernel->getContainer()
    //         ->get('doctrine')
    //         ->getManager();
    // }

    // public function testNewAction()
    // {
    //     $client = self::createClient();

    //     $crawler = $client->request('POST', $this->URL, ['name' => 'Project'.rand(0, 999)]);

    //     $this->assertEquals(201, $client->getResponse()->getStatusCode());
    //     $this->assertTrue($client->getResponse()->headers->has('Location'));        
    // }

    // public function testShowAction()
    // {
    //     $client = self::createClient();

    //     $crawler = $client->request('GET', $this->URL);

    //     $this->assertTrue($client->getResponse()->isSuccessful());
    //     $this->assertTrue(
    //         $client->getResponse()->headers->contains(
    //             'Content-Type',
    //             'application/json'
    //         ),
    //         'the "Content-Type" header is "application/json"'
    //     );
    // }
    public function testExample()
    {
        $this->assertTrue(true);
    }
    // /**
    //  * {@inheritDoc}
    //  */
    // protected function tearDown()
    // {
    //     parent::tearDown();

    //     $this->em->close();
    //     $this->em = null; // avoid memory leaks
    // }
}