<?php

namespace Ekyna\Bundle\SurveyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ekyna\Bundle\SurveyBundle\Entity\Choice;
use Ekyna\Bundle\SurveyBundle\Entity\Question;
use Ekyna\Bundle\SurveyBundle\Entity\Survey;
use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
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

        // Creates 3 surveys
        for ($s = 0; $s < 3; $s++) {
            $survey = new Survey();
            $survey
                ->setName(sprintf('Survey %d test name', $s))
                ->setTitle($faker->sentence())
                ->setDescription('<p>' . $faker->paragraph(rand(4, 6)) . '</p>')
                ->setStartDate($startDate = $faker->dateTimeBetween('-3 month', 'now'))
                ->setEndDate($faker->dateTimeBetween($startDate, 'now'))
            ;

            // Creates from 3 to 6 questions
            $qLimit = rand(3,6);
            for ($q = 0; $q < $qLimit; $q++) {
                $question = new Question();
                $question
                    ->setType(50 < rand(0, 100) ? QuestionTypes::MULTIPLE_CHOICES : QuestionTypes::SINGLE_CHOICE)
                    ->setContent(rtrim($faker->paragraph(rand(1,3)), '.') . ' ?')
                ;

                // Creates from 2 to 6 choices
                $cLimit = rand(2,6);
                for ($c = 0; $c < $cLimit; $c++) {
                    $choice = new Choice();
                    $choice
                        ->setContent($faker->sentence())
                    ;

                    $question->addChoice($choice);
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
