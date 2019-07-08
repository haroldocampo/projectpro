<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 18/09/2017
 * Time: 6:58 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('firstName')
            ->add('lastName')
            ->remove('plainPassword')
            ->remove('username');
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

}