<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\View;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class AbstractAnswerChoiceType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractAnswerChoiceType extends AbstractAnswerType
{
    /**
     * {@inheritdoc}
     */
    public function requireChoices()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if ($answer->getChoices()->count() === 0) {
            $context->addViolationAt('value', 'ekyna_survey.answer.at_least_one_choice');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswersResults(QuestionInterface $question, EntityManagerInterface $em)
    {
        $results = parent::getAnswersResults($question, $em);

        // Add missing choices results
        foreach ($question->getChoices() as $choice) {
            foreach ($results as $result) {
                if ($result['id'] == $choice->getId()) {
                    continue 2;
                }
            }
            array_push($results, array(
                'id'      => $choice->getId(),
                'content' => $choice->getContent(),
                'num'     => 0,
            ));
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswersResultsQuery(EntityManagerInterface $em)
    {
        if (null === $this->answersResultsQuery) {
            $this->answersResultsQuery = $em->createQuery(
                'SELECT c.id AS id, c.content AS content, COUNT(c.id) AS num ' .
                'FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a ' .
                'JOIN a.choices c ' .
                'JOIN a.question q ' .
                'WHERE q = :question ' .
                'GROUP BY c.id ' .
                'ORDER BY num DESC'
            );
        }

        return $this->answersResultsQuery;
    }
}
