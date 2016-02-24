<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\View;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Entity as Entity;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;

/**
 * Class Builder
 * @package Ekyna\Bundle\SurveyBundle\Survey\View
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Builder
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
    public function __construct(
        AnswerTypeRegistryInterface $registry,
        EntityManagerInterface $manager
    ) {
        $this->registry = $registry;
        $this->manager = $manager;
    }

    /**
     * Builds the survey view.
     *
     * @param SurveyInterface $survey
     *
     * @return Survey
     */
    public function build(SurveyInterface $survey)
    {
        $resultCount = $this->manager->createQuery(
            'SELECT COUNT(r.id) '.
            'FROM Ekyna\Bundle\SurveyBundle\Entity\Result r ' .
            'WHERE r.survey = :survey'
        )->setParameters(array(
            'survey' => $survey
        ))
        ->getSingleScalarResult();

        $view = new Survey(
            $survey->getTitle(),
            $survey->getDescription(),
            $resultCount
        );

        foreach ($survey->getQuestions() as $question) {
            $view->addQuestion($this->buildQuestion($question));
        }

        return $view;
    }

    /**
     * Builds the question view.
     *
     * @param QuestionInterface $question
     *
     * @return Question
     */
    private function buildQuestion(QuestionInterface $question)
    {
        $type = $this->registry->getType($question->getType());

        $answers = $type->buildQuestionViewAnswers($question, $this->manager);
        $colors = array_values(self::getColors());

        $count = 0;
        foreach ($answers as $answer) {
            if (isset($colors[$count])) {
                $answer->setColor($colors[$count]);
            }
            $count++;
        }

        return new Question(
            $question->getType(),
            $question->getContent(),
            $answers
        );
    }

    /**
     * Returns the answers colors.
     *
     * @return array
     */
    public static function getColors()
    {
        return array(
            'dc143c', // crimson
            '0000ff', // blue
            '8a2be2', // blueviolet
            '006400', // darkgreen
            'ff8c00', // darkorange
            '00ffff', // cyan
            'a52a2a', // brown
            'ffd700', // gold
            '7fff00', // chartreuse
            'ffa500', // orange
            'ff00ff', // magenta
            '008b8b', // darkcyan
            'deb887', // burlywood
            'ffff00', // yellow
            '5f9ea0', // cadetblue
            'd2691e', // chocolate
            '32cd32', // limegreen
            '8b008b', // darkmagenta
            'ff69b4', // hotpink
            'daa520', // goldenrod
        );
    }
}
