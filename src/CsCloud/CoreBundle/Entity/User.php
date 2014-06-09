<?php

namespace CsCloud\CoreBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
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
     * @var \Doctrine\Common\Collections\Collection $clients
     *
     * @ORM\ManyToMany(targetEntity="Client", inversedBy="users")
     * @ORM\JoinTable(name="user_client",
     *          joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *          inverseJoinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")}
     *      )
     * @JMS\ReadOnly()
     */
    private $clients;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $gruppi
     *
     * @ORM\OneToMany(targetEntity="\CsCloud\CoreBundle\Entity\Gruppo", mappedBy="createdBy")
     */
    private $gruppi;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->clients = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set profile
     *
     * @param \CsCloud\CoreBundle\Entity\UserProfile $profile
     * @return User
     */
    public function setProfile(\CsCloud\CoreBundle\Entity\UserProfile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Add clients
     *
     * @param \CsCloud\CoreBundle\Entity\Client $clients
     * @return User
     */
    public function addClient(\CsCloud\CoreBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \CsCloud\CoreBundle\Entity\Client $clients
     */
    public function removeClient(\CsCloud\CoreBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    public function isAuthorizedClient(Client $client)
    {
        return $this->getClients()->exists(function($key, $element) use ($client) {
            return $element->getId() === $client->getId();
        });
    }

    /**
     * Add gruppi
     *
     * @param \CsCloud\CoreBundle\Entity\Gruppo $gruppi
     * @return User
     */
    public function addGruppi(\CsCloud\CoreBundle\Entity\Gruppo $gruppi)
    {
        $this->gruppi[] = $gruppi;

        return $this;
    }

    /**
     * Remove gruppi
     *
     * @param \CsCloud\CoreBundle\Entity\Gruppo $gruppi
     */
    public function removeGruppi(\CsCloud\CoreBundle\Entity\Gruppo $gruppi)
    {
        $this->gruppi->removeElement($gruppi);
    }

    /**
     * Get gruppi
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGruppi()
    {
        return $this->gruppi;
    }
}
