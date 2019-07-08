<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/26/2017
 * Time: 7:39 AM
 */

namespace AppBundle\EventListener;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PasswordResetListener implements EventSubscriberInterface
{

    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    /**
     * (@inheritdoc)
     */
    public static function getSubscribedEvents()
    {
        return [
//            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResetSuccess'
        ];
    }

    public function onPasswordResetSuccess(FormEvent $event) {
//        $url = $this->router->generate('fos_user_security_login');
        $url = $this->router->generate('resetPasswordConfirmed');
        $event->setResponse(new RedirectResponse($url));
    }

}