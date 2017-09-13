<?php

namespace AppBundle\Form;

use AppBundle\Entity\Toon;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'Femme' => 'Femme',
                    'Homme' => 'Homme',
                ),
            ))
            ->add('Age', IntegerType::class)
            ->add('submit', SubmitType::class,[
            'attr' => [
                'class' => 'btn btn-success pull-right'
            ]
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Toon::class
        ]);
    }
}