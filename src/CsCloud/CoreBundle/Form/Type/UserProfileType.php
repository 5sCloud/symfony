<?php
namespace CsCloud\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('surname');
        $builder->add('work');
        $builder->add('hobby');
        $builder->add('house_phone');
        $builder->add('cell_phone');
        $builder->add('avatar', 'file', array('required' => false,));
        $builder->add('Salva', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CsCloud\CoreBundle\Entity\UserProfile'
        ));
    }

    public function getName()
    {
        return 'userprofile';
    }
}