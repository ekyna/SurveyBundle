<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class QuestionValidator
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class QuestionValidator extends ConstraintValidator
{
    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;


    /**
     * Constructor.
     *
     * @param AnswerTypeRegistryInterface $registry
     */
    public function __construct(AnswerTypeRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($question, Constraint $constraint)
    {
        if (!$question instanceof QuestionInterface) {
            throw new UnexpectedTypeException($constraint, 'Ekyna\Bundle\SurveyBundle\Model\QuestionInterface');
        }
        if (!$constraint instanceof Question) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Question');
        }

        /**
         * @var QuestionInterface $question
         * @var Question          $constraint
         */
        $type = $this->registry->getType($question->getType());
        $type->requireChoices();

        if (!$type->requireChoices() && 0 < $question->getChoices()->count()) {
            $this->context->addViolationAt('choices', $constraint->choicesMustBeEmpty);
        } elseif ($type->requireChoices() && 2 > $question->getChoices()->count()) {
            $this->context->addViolationAt('choices', $constraint->atLeastTwoChoice);
        }
    }
}
