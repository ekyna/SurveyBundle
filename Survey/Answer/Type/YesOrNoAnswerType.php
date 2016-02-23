<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class YesOrNoAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class YesOrNoAnswerType implements AnswerTypeInterface
{
    /**
     * @var Translator
     */
    private $translator;

    private $choices = array(
        'yes' => 'ekyna_core.value.yes',
        'no'  => 'ekyna_core.value.no',
    );

    /**
     * @var \Doctrine\ORM\Query
     */
    private $chartQuery;


    /**
     * Constructor.
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'choice', array(
            'label' => $question->getContent(),
            'choices' => $this->choices,
            'expanded' => true,
            'attr' => array('class' => 'inline'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if (!in_array($answer->getValue(), array('no', 'yes'), true)) {
            $context->addViolationAt('value', 'ekyna_survey.answer.bool_value_is_mandatory');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildChart(QuestionInterface $question, EntityManagerInterface $em)
    {
        $qb = $em->createQueryBuilder();

        if (null === $this->chartQuery) {
            $this->chartQuery = $qb
                ->from('Ekyna\Bundle\SurveyBundle\Entity\Answer', 'a')
                ->join('a.question', 'q')
                ->andWhere('q = :question')
                ->andWhere('a.value = :value')
                ->getQuery();
        }

        $data = [];
        $query = $em->createQuery(
            'SELECT COUNT(a.id) ' .
            'FROM Ekyna\Bundle\SurveyBundle\Entity\Answer a '.
            'JOIN a.question q '.
            'WHERE q = :question AND a.value = :value '
        );

        $total = 0;
        foreach ($this->choices as $key => $value) {
            $count = $query
                ->setParameters(array(
                    'question' => $question,
                    'value'    => $key
                ))
                ->getSingleScalarResult()
            ;
            $total += $count;

            $data[] = array($this->translator->trans($value), intval($count));
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

        $ob->chart->renderTo('q_chart_'.$question->getId());
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
        $ob->tooltip->pointFormat('<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.1f}%</b> of total<br/>');

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
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixtureData(AnswerInterface $answer, $faker)
    {
        $answer->setValue(50 < rand(0, 100) ? 'no' : 'yes');
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.yes_or_no';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yes_or_no';
    }
}
