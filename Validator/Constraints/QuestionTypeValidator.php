<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Ekyna\Bundle\SurveyBundle\Entity\Survey as Entity;
use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class QuestionTypeValidator
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class QuestionTypeValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($type, Constraint $constraint)
    {
        if (!$constraint instanceof QuestionType) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\QuestionType');
        }

        /**
         * @var mixed        $type
         * @var QuestionType $constraint
         */
        if (!QuestionTypes::isValid($type)) {
            $this->context->addViolation($constraint->invalid);
        }
    }
}
