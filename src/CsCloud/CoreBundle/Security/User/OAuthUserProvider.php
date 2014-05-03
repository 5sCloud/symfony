<?php

namespace CsCloud\CoreBundle\Security\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class OAuthUserProvider extends BaseProvider implements UserProviderInterface
{
}
