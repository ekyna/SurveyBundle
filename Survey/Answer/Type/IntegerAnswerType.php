<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class IntegerAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class IntegerAnswerType implements AnswerTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'integer', array(
            'label' => $question->getContent(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if (!ctype_digit(strval($answer->getValue())) && 0 > $answer->getValue()) {
            $context->addViolationAt('value', 'ekyna_survey.answer.integer_value_is_mandatory');
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
        $answer->setValue(rand(0, 10));
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.integer';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'integer';
    }
}
