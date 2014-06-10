<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use CsCloud\CoreBundle\File\CondemnedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="fos_user_profile")
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 * @author Edoardo Rossi <edo@ravers.it>
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
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $surname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $work;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $hobby;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $housePhone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $avatarFilename;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $avatar;

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
     * Set housePhone
     *
     * @param string $housePhone
     * @return UserProfile
     */
    public function setHousePhone($housePhone)
    {
        $this->housePhone = $housePhone;

        return $this;
    }

    /**
     * Get housePhone
     *
     * @return string
     */
    public function getHousePhone()
    {
        return $this->housePhone;
    }

    /**
     * Set cellPhone
     *
     * @param string $cellPhone
     * @return UserProfile
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return string
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    protected function getUploadRootDir()
    {
        // il percorso assoluto della cartella dove i
        // documenti caricati verranno salvati
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // togliamo __DIR__ in modo da visualizzare
        // correttamente nella vista il file caricato
        return 'uploads/avatar';
    }

    public function getAbsolutePath()
    {
        return null === $this->getAvatarFilename()
            ? null
            : $this->getUploadRootDir().'/'. $this->getAvatarFilename();
    }

    public function getRelativePath()
    {
        return null === $this->getAvatarFilename()
            ? null
            : $this->getUploadDir().'/'. $this->getAvatarFilename();
    }

    /**
     * Sets avatar.
     *
     * @param string $file
     */
    public function setAvatarFilename($file = null)
    {
        $this->avatarFilename = $file;
    }

    /**
     * Get avatar.
     *
     * @return string
     */
    public function getAvatarFilename()
    {
        return $this->avatarFilename;
    }

    /**
     * Sets avatar.
     *
     * @param File $file
     */
    public function setAvatar(File $file = null)
    {
        $this->avatar = $file;
    }

    /**
     * get avatar.
     *
     * @return File
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    protected function generateAvatarFilename()
    {
        if ($this->getAvatar() === null) {
            return $this->getAvatarFilename();  // No change
        }

        if ($this->getAvatar() instanceof CondemnedFile) {
            return null;
        }

        $filename = sha1(rand(5, 20));
        $extension = $this->getAvatar()->guessExtension() or
            $extension = $this->getAvatar()->guessClientExtension() or
            $extension = $this->getAvatar()->getExtension();

        if ($extension !== null) {
            $filename .= ".{$extension}";
        }
        return $filename;
    }

    public function removeAvatarFile()
    {
        $oldPath = $this->getAbsolutePath();
        if (null !== $oldPath) {
            @unlink($oldPath);
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->setAvatarFilename($this->generateAvatarFilename());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        if (null === $this->getAvatar()) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getAvatar()->move(
            $this->getUploadRootDir(),
            $this->getAvatarFilename()
        );

        $this->setAvatar(null);
    }
}
