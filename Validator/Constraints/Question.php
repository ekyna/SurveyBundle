<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Question
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Question extends Constraint
{
    public $invalidType = 'ekyna_survey.question.invalid_type';
    public $choicesMustBeEmpty = 'ekyna_survey.question.choices_must_be_empty';
    public $atLeastTwoChoice = 'ekyna_survey.question.at_least_two_choice';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'ekyna_survey_question';
    }
}
