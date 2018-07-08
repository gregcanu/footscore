<?php

namespace FS\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('season', ChoiceType::class, array(
                    'choices' => array(
                        '2017-2018' => '1718',
                        '2016-2017' => '1617',
                        '2015-2016' => '1516',
                        '2014-2015' => '1415',
                        '2013-2014' => '1314',
                    ),
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Saison',
                    'data' => $options['data']['season'],
                ))
                ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'validation_groups' => false
        ));
    }

}
