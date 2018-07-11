<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tecnicos = $options['tecnicos'];

        $builder
            ->add('tecnico_id', ChoiceType::class, array(
                    'choices' => $tecnicos,
                    'choice_label' => function ($choiceValue, $key, $value) {
                        return $choiceValue->getNombres();
                    },
                    'choice_value' => function ($entity = null) {
                        return $entity ? $entity->getId() : '';
                    })
            )
            ->add('descripccion', TextareaType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket',
            'tecnicos' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
