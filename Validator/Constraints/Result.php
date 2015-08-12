<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Result
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Result extends Constraint
{
    public $missingAnswer;

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
