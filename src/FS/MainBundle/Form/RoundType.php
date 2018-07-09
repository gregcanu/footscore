<?php

namespace FS\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoundType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $rounds = array();
        for ($i = 1; $i <= 38; $i++) {
            $rounds[$i] = $i;
        }
        $builder
                ->add('round', ChoiceType::class, array(
                    'choices' => $rounds,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Journée',
                    'data' => $options['data']['round'],
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Envoyer'
                ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'validation_groups' => false
        ));
    }

}
