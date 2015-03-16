<?php

namespace Ekyna\Bundle\SurveyBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ekyna\Bundle\SurveyBundle\Entity\Answer;
use Ekyna\Bundle\SurveyBundle\Entity\Result;
use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadResultData
 * @package Ekyna\Bundle\SurveyBundle\DataFixtures\ORM
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class LoadResultData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $om)
    {
        /** @var \Ekyna\Bundle\SurveyBundle\Entity\Survey[] $surveys */
        $surveys = $this->container->get('ekyna_survey.survey.repository')->findAll();

        // For each surveys
        foreach ($surveys as $survey) {

            // Create 15 results
            for ($r = 0; $r < 15; $r++) {
                $result = new Result();
                $result
                    ->setDate(new \DateTime())
                    ->setSurvey($survey)
                ;

                // For each survey questions
                foreach ($survey->getQuestions() as $question) {
                    // Random choices
                    $questionChoices = $question->getChoices()->toArray();
                    $limit = $question->getType() === QuestionTypes::MULTIPLE_CHOICES ? rand(1, count($questionChoices)) : 1;
                    $answerChoices = $this->getArrayRandomElements($questionChoices, $limit);

                    $answer = new Answer();
                    $answer
                        ->setQuestion($question)
                        ->setChoices(new ArrayCollection($answerChoices))
                    ;

                    $result->addAnswer($answer);
                }

                $om->persist($result);
                $om->flush();
            }
        }
    }

    /**
     * Returns random elements from the values.
     *
     * @param array $values
     * @param int $limit
     * @return array
     */
    private function getArrayRandomElements(array $values, $limit = 1)
    {
        $values = array_values($values);
        shuffle($values);
        $return = array();
        for ($i = 0; $i < $limit; $i++) {
            if (!array_key_exists($i, $values)) {
                var_dump($values);
                exit();
            }
            $return[] = $values[$i];
        }
        return $return;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 99;
    }
}
