<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * CsCloud\CoreBundle\Entity\Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CsCloud\CoreBundle\Entity\ClientRepository")
 */
class Client extends BaseClient
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection $users
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="clients")
     */
    private $users;

    /**
     * @var boolean $trusted
     *
     * @ORM\Column(name="trusted", type="boolean")
     */
    private $trusted;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trusted = false;
    }

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
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add users
     *
     * @param \CsCloud\CoreBundle\Entity\User $users
     * @return Client
     */
    public function addUser(\CsCloud\CoreBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \CsCloud\CoreBundle\Entity\User $users
     */
    public function removeUser(\CsCloud\CoreBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set trusted
     *
     * @param boolean $trusted
     * @return Client
     */
    public function setTrusted($trusted)
    {
        $this->trusted = $trusted;

        return $this;
    }

    /**
     * Get trusted
     *
     * @return boolean 
     */
    public function getTrusted()
    {
        return $this->trusted;
    }
}
