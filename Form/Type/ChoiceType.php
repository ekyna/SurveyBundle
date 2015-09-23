<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChoiceType
 * @package Ekyna\Bundle\SurveyBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'text', [
                'label' => false,
                'attr' => [
                    'widget_col' => 12,
                ]
            ])
            ->add('position', 'hidden', [
                'attr' => [
                    'data-collection-role' => 'position',
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'Ekyna\Bundle\SurveyBundle\Entity\Choice',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey_choice';
    }
}
