<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class QuestionType
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class QuestionType extends Constraint
{
    public $invalid = 'ekyna_survey.question.type.invalid';
}
