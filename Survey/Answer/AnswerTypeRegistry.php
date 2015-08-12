<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer;

use Ekyna\Bundle\SurveyBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SurveyBundle\Exception\UnexpectedTypeException;

/**
 * Class AnswerTypeRegistry
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AnswerTypeRegistry implements AnswerTypeRegistryInterface
{
    /**
     * @var AnswerTypeInterface[]
     */
    protected $types;

    /**
     * @var array
     */
    protected $formChoices;

    /**
     * Constructor.
     *
     * @param AnswerTypeInterface[] $types
     */
    public function __construct(array $types = array())
    {
        $this->types = [];
        foreach ($types as $type) {
            if (!$type instanceof AnswerTypeInterface) {
                throw new UnexpectedTypeException($type, 'Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeInterface');
            }
            $this->addType($type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addType(AnswerTypeInterface $type)
    {
        if ($this->hasType($type->getName())) {
            throw new InvalidArgumentException(sprintf('Answer type named "%s" is already registered.', $type->getName()));
        }

        $this->types[$type->getName()] = $type;

        // So that form choices will be rebuilt
        $this->formChoices = null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return array_key_exists($name, $this->types);
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!$this->hasType($name)) {
            throw new InvalidArgumentException(sprintf('No answer type named "%s" is registered.', $name));
        }

        return $this->types[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypeFormChoices()
    {
        if (null === $this->formChoices) {
            $this->formChoices = array();
            foreach ($this->types as $type) {
                $this->formChoices[$type->getName()] = $type->getLabel();
            }
        }
        return $this->formChoices;
    }
}
