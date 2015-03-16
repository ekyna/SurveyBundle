<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class QuestionType
 * @package Ekyna\Bundle\SurveyBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('content', 'textarea', array(
                'label' => 'ekyna_core.field.content',
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'simple',
                )
            ))
            ->add('type', 'choice', array(
                'label' => 'ekyna_core.field.type',
                'choices' => QuestionTypes::getChoices(),
            ))
            ->add('position', 'hidden', array(
                'attr' => array(
                    'data-collection-role' => 'position',
                ),
            ))
            ->add('choices', 'ekyna_core_collection', array(
                'label'           => 'ekyna_survey.choice.label.plural',
                'type'            => 'ekyna_survey_choice',
                'allow_add'       => true,
                'allow_sort'      => true,
                'allow_delete'    => true,
                'add_button_text' => 'ekyna_survey.choice.button.add',
                'sub_widget_col'  => 9,
                'button_col'      => 3,
                'prototype_name'  => '__rname__',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Ekyna\Bundle\SurveyBundle\Entity\Question',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey_question';
    }
}
