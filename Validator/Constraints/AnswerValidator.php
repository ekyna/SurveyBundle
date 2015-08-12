<?php

namespace Ekyna\Bundle\SurveyBundle\Validator\Constraints;

use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class AnswerValidator
 * @package Ekyna\Bundle\SurveyBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AnswerValidator extends ConstraintValidator
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
    public function validate($answer, Constraint $constraint)
    {
        if (!$answer instanceof AnswerInterface) {
            throw new UnexpectedTypeException($constraint, 'Ekyna\Bundle\SurveyBundle\Model\AnswerInterface');
        }
        if (!$constraint instanceof Answer) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Answer');
        }

        /**
         * @var AnswerInterface $answer
         * @var Answer          $constraint
         */
        if (null === $question = $answer->getQuestion()) {
            return;
        }
        $type = $this->registry->getType($question->getType());
        $type->validate($answer, $this->context);
    }
}
