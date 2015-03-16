<?php

namespace Ekyna\Bundle\SurveyBundle\Event;

use Ekyna\Bundle\SurveyBundle\Entity\Result;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ResultEvent
 * @package Ekyna\Bundle\SurveyBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ResultEvent extends Event
{
    /**
     * @var Result
     */
    private $result;


    /**
     * Constructor.
     *
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the result.
     *
     * @return Result
     */
    public function getComplete()
    {
        return $this->result;
    }
}
