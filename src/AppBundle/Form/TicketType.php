<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tecnicos = $options['tecnicos'];

        $builder
            ->add('tecnico', ChoiceType::class, array(
                'placeholder' => 'Seleccione un tecnico',
                'choices' => $tecnicos,
                'choice_label' => function ($choiceValue, $key, $value) {
                    return $choiceValue->getNombres();
                },
                'choice_value' => function ($entity = null) {
                    return $entity ? $entity->getId() : '';
                })
            )
//            ->add('tecnico', CollectionType::class, array(
//                    'entry_type' => ChoiceType::class,
//                    'entry_options' => array(
//                        'choices' => $tecnicos,
//                        'choice_label' => function ($choiceValue, $key, $value) {
//                            return $choiceValue->getNombres();
//                        },
//                        'choice_value' => function ($entity = null) {
//                            return $entity ? $entity->getId() : '';
//                        }
//                    ))
//            )
            ->add('descripccion', TextareaType::class);
    }

    /**
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
