<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class TextAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TextAnswerType implements AnswerTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'text', array(
            'label' => $question->getContent(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if (0 === strlen($answer->getValue())) {
            $context->addViolationAt('value', 'ekyna_survey.answer.text_value_is_mandatory');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildChart(QuestionInterface $question, EntityManagerInterface $em)
    {
        // No chart
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
        $answer->setValue($faker->sentence());
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text';
    }
}
