<?php

namespace Ekyna\Bundle\SurveyBundle\Event;

use Ekyna\Bundle\AdminBundle\Event\ResourceEvent;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;

/**
 * Class SurveyEvent
 * @package Ekyna\Bundle\SurveyBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyEvent extends ResourceEvent
{
    /**
     * Constructor.
     *
     * @param SurveyInterface $survey
     */
    public function __construct(SurveyInterface $survey)
    {
        $this->setResource($survey);
    }

    /**
     * Returns the survey.
     *
     * @return SurveyInterface
     */
    public function getSurvey()
    {
        return $this->getResource();
    }
}
