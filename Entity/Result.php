<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Result
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Result
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Survey
     */
    private $survey;

    /**
     * @var ArrayCollection|Answer[]
     */
    private $answers;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
     * Sets the date.
     *
     * @param \DateTime $date
     * @return Result
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Returns the date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the survey.
     *
     * @param Survey $survey
     * @return Result
     */
    public function setSurvey(Survey $survey)
    {
        $this->survey = $survey;
        return $this;
    }

    /**
     * Returns the survey.
     *
     * @return Survey
     */
    public function getSurvey()
    {
        return $this->survey;
    }

    /**
     * Sets the answers.
     *
     * @param ArrayCollection $answers
     * @return Result
     */
    public function setAnswers(ArrayCollection $answers)
    {
        $this->answers = $answers;
        return $this;
    }

    /**
     * Returns whether the result has the answer.
     *
     * @param Answer $answer
     * @return bool
     */
    public function hasAnswer(Answer $answer)
    {
        return $this->answers->contains($answer);
    }

    /**
     * Adds the answer.
     *
     * @param Answer $answer
     * @return Result
     */
    public function addAnswer(Answer $answer)
    {
        if (!$this->hasAnswer($answer)) {
            $answer->setResult($this);
            $this->answers->add($answer);
        }
        return $this;
    }

    /**
     * Removes the answer.
     *
     * @param Answer $answer
     * @return Result
     */
    public function removeAnswer(Answer $answer)
    {
        if ($this->removeAnswer($answer)) {
            $answer->setResult(null);
            $this->answers->removeElement($answer);
        }
        return $this;
    }

    /**
     * Returns the answers.
     *
     * @return ArrayCollection|Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
