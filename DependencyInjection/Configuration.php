<?php

namespace Ekyna\Bundle\SurveyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\SurveyBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_survey');

        $this->addPoolsSection($rootNode);

        return $treeBuilder;
    }

	/**
     * Adds admin pool sections.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addPoolsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('pools')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('survey')
                            ->isRequired()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue(array(
                                    '_form.html' => 'EkynaSurveyBundle:Admin/Survey:_form.html',
                                    'show.html'  => 'EkynaSurveyBundle:Admin/Survey:show.html',
                                    'reset.html'  => 'EkynaSurveyBundle:Admin/Survey:reset.html',
                                ))->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\SurveyBundle\Entity\Survey')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\SurveyBundle\Controller\Admin\SurveyController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Bundle\SurveyBundle\Entity\SurveyRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\SurveyBundle\Form\Type\SurveyType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\SurveyBundle\Table\Type\SurveyType')->end()
                                ->scalarNode('event')->defaultValue('Ekyna\Bundle\SurveyBundle\Event\SurveyEvent')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
