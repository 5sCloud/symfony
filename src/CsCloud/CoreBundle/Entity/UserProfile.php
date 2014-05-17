<?php

namespace CsCloud\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_profile")
 *
 * @JMS\ExclusionPolicy("all")
 * 
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $avatarPath;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $avatar;

    private $temp;

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

    public function getAbsolutePath()
    {
        return null === $this->$avatarPath
            ? null
            : $this->getUploadRootDir().'/'.$this->$avatarPath;
    }

    public function getWebPath()
    {
        return null === $this->$avatarPath
            ? null
            : $this->getUploadDir().'/'.$this->$avatarPath;
    }

    protected function getUploadRootDir()
    {
        // il percorso assoluto della cartella dove i
        // documenti caricati verranno salvati
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // togliamo __DIR_ in modo da visualizzare
        // correttamente nella vista il file caricato
        return 'uploads/avatar';
    }

    public function upload()
    {

        // the file property can be empty if the field is not required
        if (!$this->avatar ) {
            return;
        }

        if (strtolower($this->avatar->getClientOriginalExtension()) != 'jpg' && strtolower($this->avatar->getClientOriginalExtension()) != 'png') {
            return;
        }



        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $filename = "";

        $filename = sha1(hash("sha1", $this->getUser()->getId(), $raw_output=FALSE)) . "." . $this->avatar->getClientOriginalExtension();

        // move takes the target directory and then the target filename to move to
        $this->avatar->move($this->getUploadRootDir(), $filename );

        // set the path property to the filename where you'ved saved the file
        $this->setAvatarPath($filename);

        // clean up the file property as you won't need it anymore
        unset($this->avatar);
    }

    /**
     * Sets avatar.
     *
     * @param string $file
     */
    public function setAvatarPath($file = null)
    {
        $this->avatarPath = $file;
    }

    /**
     * Get avatar.
     *
     * @return string
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setAvatar(UploadedFile $avatar = null)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
