<?php
// src/Acme/DemoBundle/Admin/PostAdmin.php

namespace CsCloud\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GruppoAdmin extends Admin
{
    protected $baseRouteName = 'sonata_gruppo';
    protected $baseRoutePattern = 'gruppo';
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('name', 'text', array('label' => 'nome'))
            ->add('parent', 'entity', array('class' => 'CsCloud\CoreBundle\Entity\Gruppo'))
            ->add('childs', 'entity', array('class' => 'CsCloud\CoreBundle\Entity\Gruppo'))
            ->add('createdAt')
            ->add('createdBy', 'entity', array('class' => 'CsCloud\CoreBundle\Entity\User'))
            ->add('enabled')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('createdAt')
            ->add('createdBy')
        ;
    }
}
