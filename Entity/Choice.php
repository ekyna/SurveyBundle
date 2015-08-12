<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;

/**
 * Class Choice
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Choice
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var QuestionInterface
     */
    private $question;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $position;


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
     * Sets the question.
     *
     * @param QuestionInterface $question
     * @return Choice
     */
    public function setQuestion(QuestionInterface $question = null)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * Returns the question.
     *
     * @return QuestionInterface
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Choice
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
     * Set position
     *
     * @param integer $position
     * @return Choice
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
