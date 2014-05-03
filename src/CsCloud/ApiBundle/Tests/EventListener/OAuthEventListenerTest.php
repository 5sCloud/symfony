<?php

namespace CsCloud\ApiBundle\Tests\EventListener;

class OAuthEventListenerTest extends \PHPUnit_Framework_TestCase
{
    use \FBMock_AssertionHelpers;

    /**
     * @dataProvider onPreAuthorizationProcessDataProvider
     */
    public function testOnPreAuthorizationProcess($trusted, $isAuthorized, $result)
    {
        $client = mock('CsCloud\CoreBundle\Entity\Client')
            ->mockReturn('getTrusted', $trusted);

        $authorized = null;

        $user = mock('CsCloud\CoreBundle\Entity\User')
            ->mockReturn('isAuthorizedClient', $isAuthorized)
            ;

        $event = mock('FOS\OAuthServerBundle\Event\OAuthEvent')
            ->mockImplementation('setAuthorizedClient', function($value) use (&$authorized) {
                $authorized = $value;
            })
            ->mockReturn('getClient', $client)
            ->mockReturn('getUser', $user)
            ;

        $repository = mock('Doctrine\Common\Persistence\ObjectRepository')
            ->mockReturn('findOneBy', $user);
        $manager = mock('Doctrine\Common\Persistence\ObjectManager')
            ->mockReturn('getRepository', $repository)
            ;
        $doctrine = mock('Doctrine\Bundle\DoctrineBundle\Registry')
            ->mockReturn('getManager', $manager)
            ;

        $listener = new \CsCloud\ApiBundle\EventListener\OAuthEventListener($doctrine);
        $listener->onPreAuthorizationProcess($event);

        $this->assertEquals($result, $authorized);
    }

    public function onPreAuthorizationProcessDataProvider()
    {
        return array(
            array(true, true, true),
            array(true, false, true),
            array(false, true, true),
            array(false, false, false)
        );
    }

    /**
     * @dataProvider onPostAuthorizationProcessDataProvider
     */
    public function testOnPostAuthorizationProcess($isAuthorized, $addClientCalled)
    {
        $user = mock('CsCloud\CoreBundle\Entity\User')
            ->mockReturn('addClient', null);

        $event = mock('FOS\OAuthServerBundle\Event\OAuthEvent')
            ->mockReturn('isAuthorizedClient', $isAuthorized)
            ->mockReturn('getClient', mock('CsCloud\CoreBundle\Entity\Client'))
            ->mockReturn('getUser', $user)
            ;

        $repository = mock('Doctrine\Common\Persistence\ObjectRepository')
            ->mockReturn('findOneBy', $user);
        $manager = mock('Doctrine\Common\Persistence\ObjectManager')
            ->mockReturn('getRepository', $repository)
            ;
        $doctrine = mock('Doctrine\Bundle\DoctrineBundle\Registry')
            ->mockReturn('getManager', $manager)
            ;

        $listener = new \CsCloud\ApiBundle\EventListener\OAuthEventListener($doctrine);
        $listener->onPostAuthorizationProcess($event);

        $this->assertNumCalls($user, 'addClient', $addClientCalled);
    }

    public function onPostAuthorizationProcessDataProvider()
    {
        return array(
            array(true, 1),
            array(false, 0),
            array(null, 0)
        );
    }
}
