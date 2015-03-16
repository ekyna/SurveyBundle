<?php

namespace Ekyna\Bundle\SurveyBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\Context;
use Ekyna\Bundle\AdminBundle\Controller\ResourceController;

/**
 * Class SurveyController
 * @package Ekyna\Bundle\SurveyBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    protected function buildShowData(array &$data, Context $context)
    {
        /** @var \Ekyna\Bundle\SurveyBundle\Entity\Survey $survey */
        $survey = $context->getResource();
        $loader = $this->get('ekyna_survey.chart.loader');

        foreach ($survey->getQuestions() as $question) {
            $loader->loadQuestionChart($question);
        }
    }
}
