<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Ekyna\Bundle\SurveyBundle\Survey\View;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class AbstractAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractAnswerType implements AnswerTypeInterface
{
    /**
     * @var \Doctrine\ORM\Query
     */
    protected $answersResultsQuery;


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
    public function fillView(View\Survey $view, QuestionInterface $question, EntityManagerInterface $em)
    {
        $results = $this->getAnswersResults($question, $em);

        $questionView = new View\Question(
            $question->getType(),
            $question->getContent()
        );

        $total = 0;
        foreach ($results as $result) {
            $total += $result['num'];
        }

        if (0 < $total) {
            $count = 0;
            foreach ($results as $result) {
                $answerView = new View\Answer(
                    $result['content'],
                    $result['num'],
                    round($result['num'] * 100 / $total, 2)
                );

                if (isset(self::getColors()[$count])) {
                    $answerView->setColor(self::getColors()[$count]);
                }

                $questionView->addAnswer($answerView);

                $count++;
            }
        }

        $view->addQuestion($questionView);
    }

    /**
     * Returns the answers results.
     *
     * @param QuestionInterface      $question
     * @param EntityManagerInterface $em
     *
     * @return array
     */
    protected function getAnswersResults(QuestionInterface $question, EntityManagerInterface $em)
    {
        return $this
            ->getAnswersResultsQuery($em)
            ->setParameters(array('question' => $question))
            ->getArrayResult();
    }

    /**
     * Returns the answers results query.
     *
     * @param EntityManagerInterface $em
     *
     * @return \Doctrine\ORM\Query
     */
    protected function getAnswersResultsQuery(EntityManagerInterface $em)
    {
        if (null === $this->answersResultsQuery) {
            $this->answersResultsQuery = $em->createQuery(
                'SELECT a.value AS content, COUNT(a.value) AS num ' .
                'FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a ' .
                'JOIN a.question q ' .
                'WHERE q = :question ' .
                'GROUP BY a.value ' .
                'ORDER BY num DESC'
            );
        }

        return $this->answersResultsQuery;
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
