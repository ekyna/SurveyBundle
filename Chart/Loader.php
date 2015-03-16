<?php

namespace Ekyna\Bundle\SurveyBundle\Chart;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Entity\Question;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Class Loader
 * @package Ekyna\Bundle\SurveyBundle\Chart
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Loader
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Loads the question chart.
     *
     * @param Question $question
     */
    public function loadQuestionChart(Question $question)
    {
        $data = [];
        $query = $this->em->createQuery(
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
}