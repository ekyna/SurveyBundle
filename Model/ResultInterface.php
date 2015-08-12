<?php

namespace Ekyna\Bundle\SurveyBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Entity\Answer;

/**
 * Interface ResultInterface
 * @package Ekyna\Bundle\SurveyBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface ResultInterface
{
    /**
     * Returns the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Sets the date.
     *
     * @param \DateTime $date
     * @return ResultInterface|$this
     */
    public function setDate(\DateTime $date);

    /**
     * Returns the date.
     *
     * @return \DateTime
     */
    public function getDate();

    /**
     * Sets the survey.
     *
     * @param SurveyInterface $survey
     * @return ResultInterface|$this
     */
    public function setSurvey(SurveyInterface $survey);

    /**
     * Returns the survey.
     *
     * @return SurveyInterface
     */
    public function getSurvey();

    /**
     * Sets the answers.
     *
     * @param ArrayCollection|AnswerInterface[] $answers
     * @return ResultInterface|$this
     */
    public function setAnswers(ArrayCollection $answers);

    /**
     * Returns whether the result has the answer.
     *
     * @param AnswerInterface $answer
     * @return bool
     */
    public function hasAnswer(AnswerInterface $answer);

    /**
     * Adds the answer.
     *
     * @param AnswerInterface $answer
     * @return ResultInterface|$this
     */
    public function addAnswer(AnswerInterface $answer);

    /**
     * Removes the answer.
     *
     * @param AnswerInterface $answer
     * @return ResultInterface|$this
     */
    public function removeAnswer(AnswerInterface $answer);

    /**
     * Returns the answers.
     *
     * @return ArrayCollection|AnswerInterface[]
     */
    public function getAnswers();
}
