<?php

namespace Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class AdminMenuPass
 * @package Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdminMenuPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroup', array(array(
            'name'     => 'survey',
            'label'    => 'ekyna_survey.label',
            'icon'     => 'question-circle',
            'position' => 90,
        )));
        $pool->addMethodCall('createEntry', array('survey', array(
            'name'     => 'surveys',
            'route'    => 'ekyna_survey_survey_admin_home',
            'label'    => 'ekyna_survey.survey.label.plural',
            'resource' => 'ekyna_survey_survey',
            'position' => 1,
        )));
    }
}
