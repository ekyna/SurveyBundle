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
        $answers = $result->getAnswers();
        $questions = $result->getSurvey()->getQuestions();
        foreach ($questions as $question) {
            foreach ($answers as $answer) {
                if ($answer->getQuestion() === $question) {
                    continue 2;
                }
            }
            $this->context->addViolation('ekyna_survey.result.incomplete');
        }
    }
}
