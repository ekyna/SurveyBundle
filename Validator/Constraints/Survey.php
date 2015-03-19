<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Survey
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Survey extends Constraint
{
    public $invalidDateRange = 'ekyna_survey.survey.invalid_date_range';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
