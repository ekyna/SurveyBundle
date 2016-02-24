<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\View;

/**
 * Class Answer
 * @package Ekyna\Bundle\SurveyBundle\Survey\View
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Answer
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $count;

    /**
     * @var float
     */
    private $percent;

    /**
     * @var float
     */
    private $color = '607d8b';


    /**
     * Constructor.
     *
     * @param string $content
     * @param int    $count
     * @param float  $percent
     */
    public function __construct($content, $count, $percent)
    {
        $this->content = $content;
        $this->count   = $count;
        $this->percent = $percent;
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
     * Returns the count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Returns the percent.
     *
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Sets the color.
     *
     * @param float $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Returns the color.
     *
     * @return float
     */
    public function getColor()
    {
        return $this->color;
    }
}
