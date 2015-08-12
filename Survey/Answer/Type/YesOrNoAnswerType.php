<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class YesOrNoAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class YesOrNoAnswerType implements AnswerTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'choice', array(
            'label' => $question->getContent(),
            'choices' => array(
                'yes' => 'ekyna_core.value.yes',
                'no' => 'ekyna_core.value.no',
            ),
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
