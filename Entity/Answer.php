<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\ResultInterface;

/**
 * Class Answer
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Answer implements AnswerInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var ResultInterface
     */
    protected $result;

    /**
     * @var QuestionInterface
     */
    protected $question;

    /**
     * @var ArrayCollection|Choice[]
     */
    protected $choices;

    /**
     * @var string
     */
    protected $value;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
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
    public function setResult(ResultInterface $result = null)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuestion(QuestionInterface $question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * {@inheritdoc}
     */
    public function setChoices(ArrayCollection $choices)
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChoice(Choice $choice)
    {
        return $this->choices->contains($choice);
    }

    /**
     * {@inheritdoc}
     */
    public function addChoice(Choice $choice)
    {
        if (!$this->hasChoice($choice)) {
            $this->addChoice($choice);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChoice(Choice $choice)
    {
        if ($this->hasChoice($choice)) {
            $this->removeChoice($choice);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * {@inheritdoc}
     */
    public function setChoice(Choice $choice)
    {
        foreach ($this->choices as $choice) {
            $this->choices->removeElement($choice);
        }
        $this->choices = new ArrayCollection([$choice]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChoice()
    {
        if ($this->choices->count() == 1) {
            return $this->choices->first();
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }
}
