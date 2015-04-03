<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\CmsBundle\Entity\Seo;
use Ekyna\Bundle\CmsBundle\Entity\TinymceBlock;
use Ekyna\Bundle\CmsBundle\Model as Cms;
use Ekyna\Bundle\CoreBundle\Model as Core;

/**
 * Class Survey
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Survey implements Core\TimestampableInterface, Core\TaggedEntityInterface
{
    use Core\TimestampableTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var ArrayCollection|Question[]
     */
    private $questions;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->seo = new Seo();
        $this->questions = new ArrayCollection();
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Survey
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Survey
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
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
     * Sets the description.
     *
     * @param string $description
     * @return Survey
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Survey
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Survey
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Survey
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the questions.
     *
     * @param ArrayCollection|Question[] $questions
     * @return Survey
     */
    public function setQuestions($questions)
    {
        foreach ($questions as $question) {
            $question->setSurvey($this);
        }
        $this->questions = $questions;
        return $this;
    }

    /**
     * Returns whether the survey has the question or not.
     *
     * @param Question $question
     * @return bool
     */
    public function hasQuestion(Question $question)
    {
        return $this->questions->contains($question);
    }

    /**
     * Adds the question.
     *
     * @param Question $question
     * @return Survey
     */
    public function addQuestion(Question $question)
    {
        if (!$this->hasQuestion($question)) {
            $question->setSurvey($this);
            $this->questions->add($question);
        }
        return $this;
    }

    /**
     * Removes the question.
     *
     * @param Question $question
     * @return Survey
     */
    public function removeQuestion(Question $question)
    {
        if ($this->hasQuestion($question)) {
            $question->setSurvey(null);
            $this->questions->removeElement($question);
        }
        return $this;
    }

    /**
     * Returns the questions.
     *
     * @return ArrayCollection|Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityTag()
    {
        if (null === $this->getId()) {
            throw new \RuntimeException('Unable to generate entity tag, as the id property is undefined.');
        }
        return sprintf('ekyna_survey.survey[id:%s]', $this->getId());
    }
}
