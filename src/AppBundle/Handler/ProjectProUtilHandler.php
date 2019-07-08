<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 09/10/2017
 * Time: 9:02 PM
 */

namespace AppBundle\Handler;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\Serializer\SerializationContext;

class ProjectProUtilHandler
{

    private $serializer;
    private $entityManager;
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->serializer = $container->get('jms_serializer');
        $this->entityManager = $container->get('doctrine.orm.default_entity_manager');
        $this->container = $container;
    }

    /**
     * @param $data
     * @return mixed|string
     */
    public function serialize($data)
    {
        return $this->serializer->serialize($data, 'json', SerializationContext::create()->enableMaxDepthChecks());
    }
    
    /**
     * @param $data
     * @return mixed|string
     */
    public function deserialize($data, $class)
    {        
        return $this->serializer->deserialize($data, $class ,'json');
    }

    /**
     * @param $id
     * @return \AppBundle\Entity\Company|null|object
     */
    public function getCompany($id)
    {
        $company = $this->entityManager
            ->getRepository('AppBundle:Company')
            ->find($id);

        if (!$company) {
            throw new NotFoundHttpException(
                sprintf(
                    'No company found with id %s',
                    $id
                )
            );
        }

        return $company;
    }

}