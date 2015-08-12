<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\ResultInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;

/**
 * Class Result
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Result implements ResultInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var SurveyInterface
     */
    protected $survey;

    /**
     * @var ArrayCollection|AnswerInterface[]
     */
    protected $answers;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritdoc}
     */
    public function setSurvey(SurveyInterface $survey)
    {
        $this->survey = $survey;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSurvey()
    {
        return $this->survey;
    }

    /**
     * {@inheritdoc}
     */
    public function setAnswers(ArrayCollection $answers)
    {
        $this->answers = $answers;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAnswer(AnswerInterface $answer)
    {
        return $this->answers->contains($answer);
    }

    /**
     * {@inheritdoc}
     */
    public function addAnswer(AnswerInterface $answer)
    {
        if (!$this->hasAnswer($answer)) {
            $answer->setResult($this);
            $this->answers->add($answer);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAnswer(AnswerInterface $answer)
    {
        if ($this->removeAnswer($answer)) {
            $answer->setResult(null);
            $this->answers->removeElement($answer);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
