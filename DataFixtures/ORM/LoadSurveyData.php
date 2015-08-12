<?php

namespace Ekyna\Bundle\SurveyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ekyna\Bundle\SurveyBundle\Entity\Choice;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadSurveyData
 * @package Ekyna\Bundle\SurveyBundle\DataFixtures\ORM
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class LoadSurveyData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        $surveyRepository = $this->container->get('ekyna_survey.survey.repository');
        $questionRepository = $this->container->get('ekyna_survey.question.repository');
        $types = $this->container->get('ekyna_survey.answer_type.registry')->getTypes();

        // Creates 3 surveys
        for ($s = 0; $s < 3; $s++) {
            if ($s == 1) {
                $startDate = $faker->dateTimeBetween('-1 day', 'now');
            } else {
                $startDate = $faker->dateTimeBetween('-3 months', '-1 month');
            }
            $endDate = clone $startDate;
            $endDate->modify('+2 weeks');

            /** @var \Ekyna\Bundle\SurveyBundle\Model\SurveyInterface $survey */
            $survey = $surveyRepository->createNew();
            $survey
                ->setName(sprintf('Survey %d test name', $s))
                ->setTitle($faker->sentence())
                ->setDescription('<p>' . $faker->paragraph(rand(4, 6)) . '</p>')
                ->setStartDate($startDate)
                ->setEndDate($endDate)
            ;

            // Creates from 3 to 6 questions
            $qLimit = rand(3,6);
            for ($q = 0; $q < $qLimit; $q++) {

                /** @var \Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface $type */
                $type = $faker->randomElement($types);

                /** @var \Ekyna\Bundle\SurveyBundle\Model\QuestionInterface $question */
                $question = $questionRepository->createNew();
                $question
                    ->setType($type->getName())
                    ->setContent(rtrim($faker->paragraph(rand(1,3)), '.') . ' ?')
                ;

                if ($type->requireChoices()) {
                    // Creates from 2 to 6 choices
                    $cLimit = rand(2, 6);
                    for ($c = 0; $c < $cLimit; $c++) {
                        $choice = new Choice();
                        $choice->setContent($faker->sentence());
                        $question->addChoice($choice);
                    }
                }

                $survey->addQuestion($question);
            }

            $om->persist($survey);
            $om->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 98;
    }
}
