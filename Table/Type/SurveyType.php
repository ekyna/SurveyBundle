<?php

namespace Ekyna\Bundle\SurveyBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class SurveyType
 * @package Ekyna\Bundle\SurveyBundle\Table\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyType extends ResourceTableType
{
    /**
     * {@inheritdoc}
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('name', 'anchor', array(
                'label' => 'ekyna_core.field.name',
                'sortable' => true,
                'route_name' => 'ekyna_survey_survey_admin_show',
                'route_parameters_map' => array(
                    'surveyId' => 'id'
                ),
            ))
            ->addColumn('startDate', 'datetime', array(
                'label' => 'ekyna_core.field.start_date',
                'sortable' => true,
            ))
            ->addColumn('endDate', 'datetime', array(
                'label' => 'ekyna_core.field.end_date',
                'sortable' => true,
            ))
            ->addColumn('actions', 'admin_actions', array(
                'buttons' => array(
                    array(
                        'label' => 'ekyna_core.button.edit',
                        'icon' => 'pencil',
                        'class' => 'warning',
                        'route_name' => 'ekyna_survey_survey_admin_edit',
                        'route_parameters_map' => array(
                            'surveyId' => 'id'
                        ),
                        'permission' => 'edit',
                    ),
                    array(
                        'label' => 'ekyna_core.button.remove',
                        'icon' => 'trash',
                        'class' => 'danger',
                        'route_name' => 'ekyna_survey_survey_admin_remove',
                        'route_parameters_map' => array(
                            'surveyId' => 'id'
                        ),
                        'permission' => 'delete',
                    ),
                ),
            ))
            ->addFilter('name', 'text', array(
                'label' => 'ekyna_core.field.name',
            ))
            ->addFilter('startDate', 'datetime', array(
                'label' => 'ekyna_core.field.start_date',
            ))
            ->addFilter('endDate', 'datetime', array(
                'label' => 'ekyna_core.field.end_date',
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
