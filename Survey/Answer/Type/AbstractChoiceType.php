<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Ekyna\Bundle\SurveyBundle\Survey\View\Answer;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class AbstractChoiceType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractChoiceType implements AnswerTypeInterface
{
    /**
     * @var \Doctrine\ORM\Query
     */
    private $choicesResultsQuery;

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
    public function requireChoices()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function buildQuestionViewAnswers(QuestionInterface $question, EntityManagerInterface $em)
    {
        $results = $this
            ->getChoicesResultsQuery($em)
            ->setParameters(array('question' => $question))
            ->getArrayResult();

        // Add missing results
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

        $total = 0;
        foreach ($results as $result) {
            $total += $result['num'];
        }

        $answers = [];
        foreach ($results as $result) {
            array_push($answers, new Answer(
                $result['content'],
                $result['num'],
                round($result['num'] * 100 / $total, 2)
            ));
        }

        return $answers;
    }

    /**
     * Returns the choices results query.
     *
     * @param EntityManagerInterface $em
     *
     * @return \Doctrine\ORM\Query
     */
    protected function getChoicesResultsQuery(EntityManagerInterface $em)
    {
        if (null === $this->choicesResultsQuery) {
            $this->choicesResultsQuery = $em->createQuery(
                'SELECT c.id AS id, c.content AS content, COUNT(c.id) AS num '.
                'FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a '.
                'JOIN a.choices c '.
                'JOIN a.question q '.
                'WHERE q = :question ' .
                'GROUP BY c.id ' .
                'ORDER BY num DESC'
            );
        }

        return $this->choicesResultsQuery;
    }
}
