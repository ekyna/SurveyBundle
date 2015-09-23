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
            ->addColumn('name', 'anchor', [
                'label' => 'ekyna_core.field.name',
                'sortable' => true,
                'route_name' => 'ekyna_survey_survey_admin_show',
                'route_parameters_map' => [
                    'surveyId' => 'id'
                ],
            ])
            ->addColumn('startDate', 'datetime', [
                'label' => 'ekyna_core.field.start_date',
                'sortable' => true,
            ])
            ->addColumn('endDate', 'datetime', [
                'label' => 'ekyna_core.field.end_date',
                'sortable' => true,
            ])
            ->addColumn('actions', 'admin_actions', [
                'buttons' => [
                    [
                        'label' => 'ekyna_core.button.edit',
                        'icon' => 'pencil',
                        'class' => 'warning',
                        'route_name' => 'ekyna_survey_survey_admin_edit',
                        'route_parameters_map' => [
                            'surveyId' => 'id'
                        ],
                        'permission' => 'edit',
                    ],
                    [
                        'label' => 'ekyna_core.button.remove',
                        'icon' => 'trash',
                        'class' => 'danger',
                        'route_name' => 'ekyna_survey_survey_admin_remove',
                        'route_parameters_map' => [
                            'surveyId' => 'id'
                        ],
                        'permission' => 'delete',
                    ],
                ],
            ])
            ->addFilter('name', 'text', [
                'label' => 'ekyna_core.field.name',
            ])
            ->addFilter('startDate', 'datetime', [
                'label' => 'ekyna_core.field.start_date',
            ])
            ->addFilter('endDate', 'datetime', [
                'label' => 'ekyna_core.field.end_date',
            ])
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
