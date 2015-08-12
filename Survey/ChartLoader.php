<?php

namespace Ekyna\Bundle\SurveyBundle\Survey;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;

/**
 * Class ChartLoader
 * @package Ekyna\Bundle\SurveyBundle\Survey
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ChartLoader
{
    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructor.
     *
     * @param AnswerTypeRegistryInterface $registry
     * @param EntityManagerInterface      $manager
     */
    public function __construct(AnswerTypeRegistryInterface $registry, EntityManagerInterface $manager)
    {
        $this->registry = $registry;
        $this->manager = $manager;
    }

    /**
     * Loads the survey charts.
     *
     * @param SurveyInterface $survey
     */
    public function loadSurveyCharts(SurveyInterface $survey)
    {
        foreach ($survey->getQuestions() as $question) {
           $this->loadQuestionChart($question);
        }
    }

    /**
     * Loads the question chart.
     *
     * @param QuestionInterface $question
     */
    public function loadQuestionChart(QuestionInterface $question)
    {
        $type = $this->registry->getType($question->getType());
        $type->buildChart($question, $this->manager);
    }
}
