<?php

namespace CsCloud\CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\ReadOnly()
     */
    protected $id;

    /**
     * @var UserProfile $profile
     *
     * @ORM\OneToOne(targetEntity="UserProfile", mappedBy="user", cascade={"remove", "persist"})
     *
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    private $profile;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get profile
     *
     * @return UserProfile 
     */
    public function getProfile()
    {
        if (null === $this->profile) {
            $this->profile = new UserProfile;
            $this->profile->setUser($this);
        }

        return $this->profile;
    }
}
