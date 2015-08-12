<?php

namespace Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AnswerTypeRegistryPass
 * @package Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AnswerTypeRegistryPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_survey.answer_type.registry')) {
            return;
        }

        $registry = $container->getDefinition('ekyna_survey.answer_type.registry');

        $types = array();
        foreach ($container->findTaggedServiceIds('ekyna_survey.answer_type') as $serviceId => $tags) {
            $types[] = new Reference($serviceId);
        }
        $registry->replaceArgument(0, $types);
    }
}
