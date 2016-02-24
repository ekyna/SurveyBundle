<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class IntegerAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class IntegerAnswerType extends AbstractValueType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'integer', [
            'label' => $question->getContent(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if (!ctype_digit(strval($answer->getValue())) && 0 > $answer->getValue()) {
            $context
                ->buildViolation('ekyna_survey.answer.integer_value_is_mandatory')
                ->atPath('value')
                ->addViolation()
            ;
        }
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