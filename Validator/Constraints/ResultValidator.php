<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Ekyna\Bundle\SurveyBundle\Model\ResultInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ResultValidator
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ResultValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($result, Constraint $constraint)
    {
        if (!$result instanceof ResultInterface) {
            throw new UnexpectedTypeException($constraint, 'Ekyna\Bundle\SurveyBundle\Model\ResultInterface');
        }
        if (!$constraint instanceof Result) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Result');
        }

        /**
         * @var ResultInterface $result
         * @var Result          $constraint
         */

        // TODO check that all questions has his answer

        /*if ($type !== QuestionTypes::TEXT && 0 === $question->getChoices()->count()) {
            $this->context->addViolationAt('choices', $constraint->atLeastOneChoice);
        }*/
    }
}
