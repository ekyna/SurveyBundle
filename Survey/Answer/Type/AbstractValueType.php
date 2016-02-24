<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Ekyna\Bundle\SurveyBundle\Survey\View\Answer;

/**
 * Class AbstractValueType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractValueType implements AnswerTypeInterface
{
    /**
     * @var \Doctrine\ORM\Query
     */
    private $valuesResultsQuery;

    /**
     * {@inheritdoc}
     */
    public function requireChoices()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function buildQuestionViewAnswers(QuestionInterface $question, EntityManagerInterface $em)
    {
        $results = $this
            ->getValuesResultsQuery($em)
            ->setParameters(array('question' => $question))
            ->getArrayResult();

        // Add missing results
        // TODO move in answer type
        if ($question->getType() === 'yes_or_no') {
            foreach (array('yes', 'no') as $choice) {
                foreach ($results as $result) {
                    if ($result['content'] == $choice) {
                        continue 2;
                    }
                }
                array_push($results, array(
                    'content' => $choice,
                    'num'     => 0,
                ));
            }
        };

        $results = $this->fixAnswersResults($results);

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
     * Fix the values results.
     *
     * @param array $results
     * @return array
     */
    protected function fixAnswersResults(array $results)
    {
        return $results;
    }

    /**
     * Returns the question values results.
     *
     * @param QuestionInterface $question
     * @param EntityManagerInterface $em
     *
     * @return array
     */
    protected function getValuesResults(QuestionInterface $question, EntityManagerInterface $em)
    {
        return $this
            ->getValuesResultsQuery($em)
            ->setParameters(array('question' => $question))
            ->getArrayResult();
    }

    /**
     * Returns the values result query.
     *
     * @param EntityManagerInterface $em
     *
     * @return \Doctrine\ORM\Query
     */
    protected function getValuesResultsQuery(EntityManagerInterface $em)
    {
        if (null === $this->valuesResultsQuery) {
            $this->valuesResultsQuery = $em->createQuery(
                'SELECT a.value AS content, COUNT(a.value) AS num '.
                'FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a '.
                'JOIN a.question q '.
                'WHERE q = :question ' .
                'GROUP BY a.value ' .
                'ORDER BY num DESC'
            );
        }

        return $this->valuesResultsQuery;
    }
}
