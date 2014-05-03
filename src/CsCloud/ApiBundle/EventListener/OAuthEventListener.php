<?php

namespace CsCloud\ApiBundle\EventListener;

use FOS\OAuthServerBundle\Event\OAuthEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;

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

    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        $em = $this->doctrine->getManager();
        $user = $em->getRepository("CsCloudCoreBundle:User")->findOneBy(array(
            'username' => $event->getUser()->getUsername()
        ));
        if (null !== $user) {
            $event->setAuthorizedClient($user->isAuthorizedClient($event->getClient()));
        }
    }

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