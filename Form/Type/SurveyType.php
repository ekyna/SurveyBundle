<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class SurveyType
 * @package Ekyna\Bundle\SurveyBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'ekyna_core.field.name',
            ))
            ->add('title', 'text', array(
                'label' => 'ekyna_core.field.title',
            ))
            ->add('description', 'tinymce', array(
                'label' => 'ekyna_core.field.description',
                'theme' => 'advanced',
            ))
            ->add('startDate', 'datetime', array(
                'label' => 'ekyna_core.field.start_date',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('endDate', 'datetime', array(
                'label' => 'ekyna_core.field.end_date',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('questions', 'ekyna_collection', array(
                'label'           => false,
                'type'            => 'ekyna_survey_question',
                'allow_add'       => true,
                'allow_sort'      => true,
                'allow_delete'    => true,
                'add_button_text' => 'ekyna_survey.question.button.add',
                'sub_widget_col'  => 11,
                'button_col'      => 1,
                'prototype_name'  => '__qname__',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey_survey';
    }
}