<?php

namespace CsCloud\ApiBundle\EventListener;

use FOS\OAuthServerBundle\Event\OAuthEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * OAuth authorization events listener
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class OAuthEventListener
{
    /**
     * @var Registry
     */
    protected $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Check for an already authorized or trusted client
     * Trusted client MUST be only an internal client (ex: frontend or our app)
     *
     * @param OAuthEvent $event
     */
    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        if ($event->getClient()->getTrusted()) {
            $event->setAuthorizedClient(true);
            return;
        }

        $em = $this->doctrine->getManager();
        $user = $em->getRepository("CsCloudCoreBundle:User")->findOneBy(array(
            'username' => $event->getUser()->getUsername()
        ));

        if (null !== $user) {
            $event->setAuthorizedClient($user->isAuthorizedClient($event->getClient()));
        }
    }

    /**
     * Store the client authorization for the current user
     *
     * @param OAuthEvent $event
     */
    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        $em = $this->doctrine->getManager();
        $user = $em->getRepository("CsCloudCoreBundle:User")->findOneBy(array(
            'username' => $event->getUser()->getUsername()
        ));

        if ($event->isAuthorizedClient()) {
            if (null !== $client = $event->getClient()) {
                $user->addClient($client);
                $em->persist($user);
                $em->flush();
            }
        }
    }
}