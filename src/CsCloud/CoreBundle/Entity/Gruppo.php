<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gruppo
 *
 * @ORM\Table(name="gruppi")
 * @ORM\Entity
 */
class Gruppo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \CsCloud\CoreBundle\Entity\Gruppo
     *
     * @ORM\ManyToOne(targetEntity="\CsCloud\CoreBundle\Entity\Gruppo", inversedBy="childs")
     * @ORM\JoinColumn(name="gruppi", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $childs
     *
     * @ORM\OneToMany(targetEntity="\CsCloud\CoreBundle\Entity\Gruppo", mappedBy="parent")
     */
    private $childs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \CsCloud\CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\CsCloud\CoreBundle\Entity\User", inversedBy="gruppi")
     * @ORM\JoinColumn(name="fos_user", referencedColumnName="id")
     */
     private $createdBy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


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
     * Constructor
     */
    public function __construct()
    {
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Gruppo
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Gruppo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Gruppo
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set parent
     *
     * @param \CsCloud\CoreBundle\Entity\Gruppo $parent
     * @return Gruppo
     */
    public function setParent(\CsCloud\CoreBundle\Entity\Gruppo $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \CsCloud\CoreBundle\Entity\Gruppo 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add childs
     *
     * @param \CsCloud\CoreBundle\Entity\Gruppo $childs
     * @return Gruppo
     */
    public function addChild(\CsCloud\CoreBundle\Entity\Gruppo $childs)
    {
        $this->childs[] = $childs;

        return $this;
    }

    /**
     * Remove childs
     *
     * @param \CsCloud\CoreBundle\Entity\Gruppo $childs
     */
    public function removeChild(\CsCloud\CoreBundle\Entity\Gruppo $childs)
    {
        $this->childs->removeElement($childs);
    }

    /**
     * Get childs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Set createdBy
     *
     * @param \CsCloud\CoreBundle\Entity\User $createdBy
     * @return Gruppo
     */
    public function setCreatedBy(\CsCloud\CoreBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \CsCloud\CoreBundle\Entity\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
