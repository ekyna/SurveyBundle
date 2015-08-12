<?php

namespace Ekyna\Bundle\SurveyBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\CoreBundle\Model as Core;
use Ekyna\Bundle\SurveyBundle\Entity\Question;

/**
 * Interface SurveyInterface
 * @package Ekyna\Bundle\SurveyBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface SurveyInterface extends Core\TimestampableInterface, Core\TaggedEntityInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return SurveyInterface|$this
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set title
     *
     * @param string $title
     * @return SurveyInterface|$this
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Returns the description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets the description.
     *
     * @param string $description
     * @return SurveyInterface|$this
     */
    public function setDescription($description);

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return SurveyInterface|$this
     */
    public function setStartDate(\DateTime $startDate);

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return SurveyInterface|$this
     */
    public function setEndDate(\DateTime $endDate);

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate();

    /**
     * Set slug
     *
     * @param string $slug
     * @return SurveyInterface|$this
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * Sets the questions.
     *
     * @param ArrayCollection|QuestionInterface[] $questions
     * @return SurveyInterface|$this
     */
    public function setQuestions(ArrayCollection $questions);

    /**
     * Returns whether the survey has the question or not.
     *
     * @param QuestionInterface $question
     * @return bool
     */
    public function hasQuestion(QuestionInterface $question);

    /**
     * Adds the question.
     *
     * @param QuestionInterface $question
     * @return SurveyInterface|$this
     */
    public function addQuestion(QuestionInterface $question);

    /**
     * Removes the question.
     *
     * @param QuestionInterface $question
     * @return SurveyInterface|$this
     */
    public function removeQuestion(QuestionInterface $question);

    /**
     * Returns the questions.
     *
     * @return ArrayCollection|Question[]
     */
    public function getQuestions();
}
