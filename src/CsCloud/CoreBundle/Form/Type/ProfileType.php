<?php
namespace CsCloud\CoreBundle\Form\Type;

use CsCloud\CoreBundle\Entity\UserProfile;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userprofile', new UserProfileType());

        $builder->add('Registrazione', 'submit');
    }

    public function getName()
    {
        return 'Profile';
    }
}