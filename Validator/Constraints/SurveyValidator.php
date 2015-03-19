<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Ekyna\Bundle\SurveyBundle\Entity\Survey as Entity;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class SurveyValidator
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($survey, Constraint $constraint)
    {
        if (!$survey instanceof Entity) {
            throw new UnexpectedTypeException($survey, '\Ekyna\Bundle\SurveyBundle\Entity\Survey');
        }
        if (!$constraint instanceof Survey) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Survey');
        }

        /**
         * @var Entity $survey
         * @var Survey $constraint
         */
        if ($survey->getStartDate() > $survey->getEndDate()) {
            $this->context->addViolationAt('endDate', $constraint->invalidDateRange);
        }
    }
}
