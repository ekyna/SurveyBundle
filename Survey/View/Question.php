<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\View;

/**
 * Class Question
 * @package Ekyna\Bundle\SurveyBundle\Survey\View
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Question
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Answer[]
     */
    private $answers;


    /**
     * Constructor.
     *
     * @param string   $type
     * @param string   $content
     * @param Answer[] $answers
     */
    public function __construct($type, $content, array $answers = array())
    {
        $this->type = $type;
        $this->content = $content;
        $this->answers = $answers;
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
     * Returns the content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the answers.
     *
     * @return Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Adds the answer.
     *
     * @param Answer $answer
     *
     * @return $this
     */
    public function addAnswer(Answer $answer)
    {
        array_push($this->answers, $answer);

        return $this;
    }
}
