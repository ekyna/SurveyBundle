<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Answer
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Answer extends Constraint
{
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
        return 'ekyna_survey_answer';
    }
}
