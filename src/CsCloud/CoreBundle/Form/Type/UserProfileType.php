<?php

namespace CsCloud\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * UserProfileType
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 * @author Edoardo Rossi <edo@ravers.it>
 */
class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('surname', 'text');
        $builder->add('work', 'text', array('required' => false));
        $builder->add('hobby', 'text', array('required' => false));
        $builder->add('house_phone', 'text', array('required' => false));
        $builder->add('cell_phone', 'text', array('required' => false));
        $builder->add('avatar', 'file', array('required' => false));
        $builder->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CsCloud\CoreBundle\Entity\UserProfile'
        ));
    }

    public function getName()
    {
        return 'cscloud_userprofile';
    }
}