<?php

namespace Ekyna\Bundle\SurveyBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Entity\Choice;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Interface QuestionInterface
 * @package Ekyna\Bundle\SurveyBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface QuestionInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Sets the survey.
     *
     * @param SurveyInterface $survey
     * @return QuestionInterface|$this
     */
    public function setSurvey(SurveyInterface $survey);

    /**
     * Returns the survey.
     *
     * @return SurveyInterface
     */
    public function getSurvey();

    /**
     * Sets the choices.
     *
     * @param ArrayCollection|Choice[] $choices
     * @return QuestionInterface|$this
     */
    public function setChoices(ArrayCollection $choices);

    /**
     * Returns whether the question has the choice or not (she probably does).
     *
     * @param Choice $choice
     * @return bool
     */
    public function hasChoice(Choice $choice);

    /**
     * Adds the choice.
     *
     * @param Choice $choice
     * @return QuestionInterface|$this
     */
    public function addChoice(Choice $choice);

    /**
     * Removes the choice.
     *
     * @param Choice $choice
     * @return QuestionInterface|$this
     */
    public function removeChoice(Choice $choice);

    /**
     * Returns the choices.
     *
     * @return ArrayCollection|Choice[]
     */
    public function getChoices();

    /**
     * Sets the type.
     *
     * @param string $type
     * @return QuestionInterface|$this
     */
    public function setType($type);

    /**
     * Returns the type.
     *
     * @return string
     */
    public function getType();

    /**
     * Set content
     *
     * @param string $content
     * @return QuestionInterface|$this
     */
    public function setContent($content);

    /**
     * Get content
     *
     * @return string
     */
    public function getContent();

    /**
     * Sets the position.
     *
     * @param int $position
     * @return QuestionInterface|$this
     */
    public function setPosition($position);

    /**
     * Returns the position.
     *
     * @return int
     */
    public function getPosition();

    /**
     * Sets the chart.
     *
     * @param Highchart $chart
     * @return QuestionInterface|$this
     */
    public function setChart(Highchart $chart = null);

    /**
     * Returns the chart.
     *
     * @return Highchart
     */
    public function getChart();
}