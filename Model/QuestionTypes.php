<?php

namespace Ekyna\Bundle\SurveyBundle\Model;

use Ekyna\Bundle\CoreBundle\Model\AbstractConstants;

/**
 * Class QuestionTypes
 * @package Ekyna\Bundle\SurveyBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
final class QuestionTypes extends AbstractConstants
{
    const SINGLE_CHOICE    = 'single';
    const MULTIPLE_CHOICES = 'multiple';

    /**
     * {@inheritdoc}
     */
    public static function getConfig()
    {
        return array(
            self::SINGLE_CHOICE    => array('ekyna_survey.question.type.single'),
            self::MULTIPLE_CHOICES => array('ekyna_survey.question.type.multiple'),
        );
    }
}
