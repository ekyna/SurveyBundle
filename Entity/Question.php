<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Class Question
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Question
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Survey
     */
    private $survey;

    /**
     * @var ArrayCollection|Choice[]
     */
    private $choices;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var Highchart
     */
    private $chart;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the survey.
     *
     * @param Survey $survey
     * @return Question
     */
    public function setSurvey($survey)
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
     * Sets the choices.
     *
     * @param ArrayCollection|Choice[] $choices
     * @return Question
     */
    public function setChoices(ArrayCollection $choices)
    {
        foreach ($choices as $choice) {
            $choice->setQuestion($this);
        }
        $this->choices = $choices;
        return $this;
    }

    /**
     * Returns whether the question has the choice or not (she probably does).
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
     * @return Question
     */
    public function addChoice(Choice $choice)
    {
        if (!$this->hasChoice($choice)) {
            $choice->setQuestion($this);
            $this->choices->add($choice);
        }
        return $this;
    }

    /**
     * Removes the choice.
     *
     * @param Choice $choice
     * @return Question
     */
    public function removeChoice(Choice $choice)
    {
        if ($this->hasChoice($choice)) {
            $choice->setQuestion(null);
            $this->choices->removeElement($choice);
        }
        return $this;
    }

    /**
     * Returns the choices.
     *
     * @return ArrayCollection|Choice[]
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Sets the type.
     *
     * @param string $type
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Returns the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Question
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the position.
     *
     * @param int $position
     * @return Question
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Returns the position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Returns the chart.
     *
     * @return Highchart
     */
    public function getChart()
    {
        return $this->chart;
    }

    /**
     * Sets the chart.
     *
     * @param Highchart $chart
     * @return Question
     */
    public function setChart(Highchart $chart = null)
    {
        $this->chart = $chart;
        return $this;
    }
}
