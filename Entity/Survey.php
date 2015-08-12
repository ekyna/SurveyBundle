<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\CmsBundle\Entity\Seo;
use Ekyna\Bundle\CoreBundle\Model as Core;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;

/**
 * Class Survey
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Survey implements SurveyInterface
{
    use Core\TimestampableTrait,
        Core\TaggedEntityTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var ArrayCollection|QuestionInterface[]
     */
    protected $questions;


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
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuestions(ArrayCollection $questions)
    {
        foreach ($questions as $question) {
            $question->setSurvey($this);
        }
        $this->questions = $questions;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasQuestion(QuestionInterface $question)
    {
        return $this->questions->contains($question);
    }

    /**
     * {@inheritdoc}
     */
    public function addQuestion(QuestionInterface $question)
    {
        if (!$this->hasQuestion($question)) {
            $question->setSurvey($this);
            $this->questions->add($question);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeQuestion(QuestionInterface $question)
    {
        if ($this->hasQuestion($question)) {
            $question->setSurvey(null);
            $this->questions->removeElement($question);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * {@inheritdoc}
     */
    public static function getEntityTagPrefix()
    {
        return 'ekyna_survey.survey';
    }
}
