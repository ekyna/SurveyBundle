<?php

namespace Ekyna\Bundle\SurveyBundle\Event;

/**
 * Class ResultEvents
 * @package Ekyna\Bundle\SurveyBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
final class ResultEvents
{
    const INITIALIZED = 'ekyna_survey.result.initialized';
    const PRE_PERSIST = 'ekyna_survey.result.pre_persist';
    const COMPLETED   = 'ekyna_survey.result.completed';
}
