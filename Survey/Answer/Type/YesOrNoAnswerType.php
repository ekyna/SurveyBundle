<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class YesOrNoAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class YesOrNoAnswerType extends AbstractValueType
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var array
     */
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
    protected function fixAnswersResults(array $results)
    {
        foreach ($this->choices as $key => $value) {
            foreach ($results as $result) {
                if ($result['content'] == $key) {
                    continue 2;
                }
            }
            array_push($results, array(
                'content' => $key,
                'num'     => 0,
            ));
        }

        foreach ($results as &$result) {
            $result['content'] = $this->translator->trans(
                $this->choices[$result['content']]
            );
        }

        return $results;
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
