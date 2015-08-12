<?php

namespace Ekyna\Bundle\SurveyBundle\Twig;

use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
use Ekyna\Bundle\SurveyBundle\Survey\ChartLoader;

/**
 * Class SurveyExtension
 * @package Ekyna\Bundle\SurveyBundle\Twig
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;

    /**
     * @var ChartLoader
     */
    private $chartLoader;


    /**
     * Constructor.
     *
     * @param AnswerTypeRegistryInterface $registry
     * @param ChartLoader                 $chartLoader
     */
    public function __construct(AnswerTypeRegistryInterface $registry, ChartLoader $chartLoader)
    {
        $this->registry    = $registry;
        $this->chartLoader = $chartLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $twig)
    {
        $this->environment = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('survey_answer_type_label', array($this, 'getAnswerTypeLabel')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_survey_results',  array($this, 'renderSurveyResults'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Returns the answer type label.
     *
     * @param string $name
     * @return string
     */
    public function getAnswerTypeLabel($name)
    {
        $type = $this->registry->getType($name);
        return $type->getLabel();
    }

    /**
     * Renders the survey results.
     *
     * @param SurveyInterface $survey
     * @param string          $template
     * @return string
     */
    public function renderSurveyResults(SurveyInterface $survey, $template = 'EkynaSurveyBundle::survey_result.html.twig')
    {
        $this->chartLoader->loadSurveyCharts($survey);

        return $this->environment->render($template, array('survey' => $survey));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey';
    }
}
