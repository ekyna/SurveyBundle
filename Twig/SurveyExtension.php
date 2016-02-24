<?php

namespace Ekyna\Bundle\SurveyBundle\Twig;

use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
use Ekyna\Bundle\SurveyBundle\Survey\ChartLoader;
use Ekyna\Bundle\SurveyBundle\Survey\View\Builder as ViewBuilder;
use Ekyna\Bundle\SurveyBundle\Survey\View\Question;
use Guzzle\Http\Url;

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
     * @var ViewBuilder
     */
    private $viewBuilder;

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
     * @param ViewBuilder                 $viewBuilder
     * @param AnswerTypeRegistryInterface $registry
     * @param ChartLoader                 $chartLoader
     */
    public function __construct(ViewBuilder $viewBuilder, AnswerTypeRegistryInterface $registry, ChartLoader $chartLoader)
    {
        $this->viewBuilder = $viewBuilder;
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
            new \Twig_SimpleFilter('survey_view', array($this, 'getSurveyView')),
            new \Twig_SimpleFilter('survey_question_chart', array($this, 'getQuestionChart')),
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
     * Returns the survey view.
     *
     * @param SurveyInterface $survey
     *
     * @return \Ekyna\Bundle\SurveyBundle\Survey\View\Survey
     */
    public function getSurveyView(SurveyInterface $survey)
    {
        return $this->viewBuilder->build($survey);
    }

    /**
     * Returns the survey chart url.
     *
     * @param Question $question
     *
     * @return \Ekyna\Bundle\SurveyBundle\Survey\View\Survey
     */
    public function getQuestionChart(Question $question)
    {
        $answers = $question->getAnswers();
        if (count($question->getAnswers()) > 20) {
            return 'http://dummyimage.com/240x120/ffffff/666666.gif&text=Too+many+answers';
        }

        $data   = [];
        $colors = [];

        $count = 0;
        foreach ($answers as $answer) {
            array_push($data, $answer->getCount());
            array_push($colors, $answer->getColor());
            $count++;
        }

        $params = array(
            'cht=p',
            'chs=240x140',
            'chd=t:' . implode(',', $data),
            'chco=' . implode('|', $colors),
        );

        return 'https://chart.googleapis.com/chart?' . implode('&', $params);
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
        return $this->environment->render($template, array(
            'view' => $this->getSurveyView($survey)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey';
    }
}
