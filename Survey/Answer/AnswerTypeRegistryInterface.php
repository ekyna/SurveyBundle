<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer;

/**
 * Interface AnswerTypeRegistryInterface
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface AnswerTypeRegistryInterface
{
    /**
     * Registers the answer type.
     *
     * @param AnswerTypeInterface $type
     */
    public function addType(AnswerTypeInterface $type);

    /**
     * Returns whether the answer type exists or not, by name.
     * @param string $name
     * @return bool
     */
    public function hasType($name);

    /**
     * Returns the answer type by name.
     *
     * @param string $name
     * @return AnswerTypeInterface
     */
    public function getType($name);

    /**
     * Returns the types.
     *
     * @return array|AnswerTypeInterface[]
     */
    public function getTypes();

    /**
     * Returns the choices for question type form type.
     *
     * @return array
     */
    public function getTypeFormChoices();
}
