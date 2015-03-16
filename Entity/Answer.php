<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Answer
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Result
     */
    private $result;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var ArrayCollection|Choice[]
     */
    private $choices;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    /**
     * Returns the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the result.
     *
     * @param Result $result
     * @return Answer
     */
    public function setResult(Result $result = null)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Returns the result.
     *
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Sets the question.
     *
     * @param Question $question
     * @return Answer
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * Returns the question.
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the choices (multiple).
     *
     * @param ArrayCollection $choices
     * @return Answer
     */
    public function setChoices(ArrayCollection $choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * Returns whether the answer has the choice or not.
     *
     * @param Choice $choice
     * @return bool
     */
    public function hasChoice(Choice $choice)
    {
        return $this->choices->contains($choice);
    }

    /**
     * Adds the choice.
     *
     * @param Choice $choice
     * @return Answer
     */
    public function addChoice(Choice $choice)
    {
        if (!$this->hasChoice($choice)) {
            $this->addChoice($choice);
        }
        return $this;
    }

    /**
     * Remove the choice.
     *
     * @param Choice $choice
     * @return Answer
     */
    public function removeChoice(Choice $choice)
    {
        if ($this->hasChoice($choice)) {
            $this->removeChoice($choice);
        }
        return $this;
    }

    /**
     * Returns the choices (multiple).
     *
     * @return Choice[]
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Sets the choice (single).
     *
     * @param Choice $choice
     * @return Answer
     */
    public function setChoice(Choice $choice)
    {
        foreach ($this->choices as $choice) {
            $this->choices->removeElement($choice);
        }
        $this->choices = new ArrayCollection(array($choice));
        return $this;
    }

    /**
     * Returns the choice (single).
     *
     * @return Choice
     */
    public function getChoice()
    {
        if ($this->choices->count() == 1) {
            return $this->choices->first();
        }
        return null;
    }
}
