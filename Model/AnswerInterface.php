<?php

namespace Ekyna\Bundle\SurveyBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Entity\Choice;

/**
 * Interface AnswerInterface
 * @package Ekyna\Bundle\SurveyBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface AnswerInterface
{
    /**
     * Returns the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Sets the result.
     *
     * @param ResultInterface $result
     * @return AnswerInterface|$this
     */
    public function setResult(ResultInterface $result = null);

    /**
     * Returns the result.
     *
     * @return ResultInterface
     */
    public function getResult();

    /**
     * Sets the question.
     *
     * @param QuestionInterface $question
     * @return AnswerInterface|$this
     */
    public function setQuestion(QuestionInterface $question);

    /**
     * Returns the question.
     *
     * @return QuestionInterface
     */
    public function getQuestion();

    /**
     * Sets the choices (multiple).
     *
     * @param ArrayCollection $choices
     * @return AnswerInterface|$this
     */
    public function setChoices(ArrayCollection $choices);

    /**
     * Returns whether the answer has the choice or not.
     *
     * @param Choice $choice
     * @return bool
     */
    public function hasChoice(Choice $choice);

    /**
     * Adds the choice.
     *
     * @param Choice $choice
     * @return AnswerInterface|$this
     */
    public function addChoice(Choice $choice);

    /**
     * Remove the choice.
     *
     * @param Choice $choice
     * @return AnswerInterface|$this
     */
    public function removeChoice(Choice $choice);

    /**
     * Returns the choices (multiple).
     *
     * @return ArrayCollection|Choice[]
     */
    public function getChoices();

    /**
     * Sets the choice (single).
     *
     * @param Choice $choice
     * @return AnswerInterface|$this
     */
    public function setChoice(Choice $choice);

    /**
     * Returns the choice (single).
     *
     * @return Choice
     */
    public function getChoice();

    /**
     * Sets the value.
     *
     * @param string $value
     * @return AnswerInterface|$this
     */
    public function setValue($value);

    /**
     * Returns the value.
     *
     * @return string
     */
    public function getValue();
}
