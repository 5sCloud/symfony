<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_profile")
 *
 * @JMS\ExclusionPolicy("all")
 */
class UserProfile
{
    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @JMS\ReadOnly()
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $work;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $hobby;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $house_phone;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $cell_phone;


    /**
     * Set user
     *
     * @param User $user
     * @return UserProfile
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return UserProfile
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
     * Set surname
     *
     * @param string $surname
     * @return UserProfile
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set work
     *
     * @param string $work
     * @return UserProfile
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * Get work
     *
     * @return string
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Set hobby
     *
     * @param string $hobby
     * @return UserProfile
     */
    public function setHobby($hobby)
    {
        $this->hobby = $hobby;

        return $this;
    }

    /**
     * Get hobby
     *
     * @return string
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * Set house_phone
     *
     * @param string $housePhone
     * @return UserProfile
     */
    public function setHousePhone($housePhone)
    {
        $this->house_phone = $housePhone;

        return $this;
    }

    /**
     * Get house_phone
     *
     * @return string
     */
    public function getHousePhone()
    {
        return $this->house_phone;
    }

    /**
     * Set cell_phone
     *
     * @param string $cellPhone
     * @return UserProfile
     */
    public function setCellPhone($cellPhone)
    {
        $this->cell_phone = $cellPhone;

        return $this;
    }

    /**
     * Get cell_phone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cell_phone;
    }
}
