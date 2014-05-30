<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 * CsCloud\CoreBundle\Entity\AccessToken
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="CsCloud\CoreBundle\Entity\User")
     */
    protected $user;
}