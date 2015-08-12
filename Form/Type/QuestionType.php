<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
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
     * @var string
     */
    private $dataClass;

    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;


    /**
     * Constructor.
     *
     * @param string                      $dataClass
     * @param AnswerTypeRegistryInterface $registry
     */
    public function __construct($dataClass, AnswerTypeRegistryInterface $registry)
    {
        $this->dataClass = $dataClass;
        $this->registry  = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'tinymce', array(
                'label' => 'ekyna_core.field.content',
                'theme' => 'simple',
            ))
            ->add('type', 'choice', array(
                'label' => 'ekyna_core.field.type',
                'choices' => $this->registry->getTypeFormChoices(),
            ))
            ->add('position', 'hidden', array(
                'attr' => array(
                    'data-collection-role' => 'position',
                ),
            ))
            ->add('choices', 'ekyna_collection', array(
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
                'data_class' => $this->dataClass,
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
