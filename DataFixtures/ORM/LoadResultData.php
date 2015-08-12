<?php

namespace Ekyna\Bundle\SurveyBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ekyna\Bundle\SurveyBundle\Entity\Answer;
use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
use Faker\Factory;
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
        $faker = Factory::create($this->container->getParameter('hautelook_alice.locale'));

        /** @var \Ekyna\Bundle\SurveyBundle\Entity\Survey[] $surveys */
        $surveys = $this->container->get('ekyna_survey.survey.repository')->findAll();
        $resultRepository = $this->container->get('ekyna_survey.result.repository');
        $answerRepository = $this->container->get('ekyna_survey.answer.repository');
        $registry = $this->container->get('ekyna_survey.answer_type.registry');

        // For each surveys
        foreach ($surveys as $survey) {

            // Create 15 results
            for ($r = 0; $r < 15; $r++) {
                $result = $resultRepository->createNew();
                $result
                    ->setDate(new \DateTime())
                    ->setSurvey($survey)
                ;

                // For each survey questions
                foreach ($survey->getQuestions() as $question) {
                    $answer = $answerRepository->createNew();
                    $answer->setQuestion($question);

                    $type = $registry->getType($question->getType());
                    $type->loadFixtureData($answer, $faker);

                    $result->addAnswer($answer);
                }

                $om->persist($result);
                $om->flush();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 99;
    }
}
