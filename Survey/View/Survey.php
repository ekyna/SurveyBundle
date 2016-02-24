<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\View;

/**
 * Class Survey
 * @package Ekyna\Bundle\SurveyBundle\Survey\View
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Survey
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $resultCount;

    /**
     * @var array
     */
    private $questions;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $description
     * @param int    $resultCount
     */
    public function __construct($title, $description, $resultCount)
    {
        $this->title = $title;
        $this->description = $description;
        $this->resultCount = $resultCount;
        $this->questions = array();
    }

    /**
     * Returns the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the resultCount.
     *
     * @return int
     */
    public function getResultCount()
    {
        return $this->resultCount;
    }

    /**
     * Returns the questions.
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Adds the question.
     *
     * @param Question $question
     *
     * @return Survey
     */
    public function addQuestion(Question $question)
    {
        array_push($this->questions, $question);

        return $this;
    }
}
