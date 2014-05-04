<?php
namespace CsCloud\CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use CsCloud\CoreBundle\Entity\UserProfile;
use CsCloud\CoreBundle\Form\Type;

class Profile
{
    /**
     * @Assert\Type(type="CsCloud\CoreBundle\Entity\UserProfile")
     * @Assert\Valid()
     */
    protected $userprofile;

    public function setUserProfile(UserProfile $user)
    {
        $this->userprofile= $user;
    }

    public function getUserProfile()
    {
        return $this->userprofile;
    }

}