<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class SingleChoiceAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SingleChoiceAnswerType implements AnswerTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('choice', 'entity', array(
            'label' => $question->getContent(),
            'choices' => $question->getChoices()->toArray(),
            'class' => 'Ekyna\Bundle\SurveyBundle\Entity\Choice',
            'expanded' => true,
            'multiple' => false,
        ));
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
    public function buildChart(QuestionInterface $question, EntityManagerInterface $em)
    {
        $data = [];
        $query = $em->createQuery(
            'SELECT COUNT(a.id) FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a '.
            'WHERE :choice MEMBER OF a.choices '
        );
        $total = 0;
        foreach ($question->getChoices() as $choice) {
            $count = $query
                ->setParameter('choice', $choice)
                ->getSingleScalarResult()
            ;
            $total += $count;

            $data[] = array((string) ($choice->getPosition()+1), intval($count));
        }

        // No answers : abort
        if ($total == 0) {
            return;
        }

        // Percents
        foreach ($data as &$d) {
            $d[1] = round($d[1] * 100 / $total, 5);
        }

        $ob = new Highchart();
        $ob->title->text(null);
        $ob->credits->enabled(false);

        $ob->chart->renderTo('q-chart-'.$question->getId());
        $ob->chart->type('pie');
        $ob->chart->spacing(array(0,0,0,0));

        $ob->plotOptions->series(
            array(
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '{point.name}: {point.y:.1f}%'
                )
            )
        );

        $ob->tooltip->headerFormat('');
        $ob->tooltip->pointFormat('<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>');

        $ob->series(
            array(
                array(
                    'name' => 'Répartition des choix',
                    'colorByPoint' => true,
                    'data' => $data
                )
            )
        );

        $question->setChart($ob);
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
    public function loadFixtureData(AnswerInterface $answer, $faker)
    {
        $questionChoices = $answer->getQuestion()->getChoices()->toArray();
        $answer->setChoice($faker->randomElement($questionChoices));
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.single_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'single_choice';
    }
}
