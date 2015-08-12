<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Class Question
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Question implements QuestionInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var SurveyInterface
     */
    protected $survey;

    /**
     * @var ArrayCollection|Choice[]
     */
    protected $choices;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var integer
     */
    protected $position;

    /**
     * @var Highchart
     */
    protected $chart;


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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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
    public function setChoices(ArrayCollection $choices)
    {
        foreach ($choices as $choice) {
            $choice->setQuestion($this);
        }
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
            $choice->setQuestion($this);
            $this->choices->add($choice);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function getChart()
    {
        return $this->chart;
    }

    /**
     * {@inheritdoc}
     */
    public function setChart(Highchart $chart = null)
    {
        $this->chart = $chart;
        return $this;
    }
}
