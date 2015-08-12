<?php

namespace Ekyna\Bundle\SurveyBundle\Event;

use Ekyna\Bundle\SurveyBundle\Model\ResultInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ResultEvent
 * @package Ekyna\Bundle\SurveyBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ResultEvent extends Event
{
    /**
     * @var ResultInterface
     */
    private $result;


    /**
     * Constructor.
     *
     * @param ResultInterface $result
     */
    public function __construct(ResultInterface $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the result.
     *
     * @return ResultInterface
     */
    public function getComplete()
    {
        return $this->result;
    }
}
