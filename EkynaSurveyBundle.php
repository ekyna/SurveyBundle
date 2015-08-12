<?php

namespace Ekyna\Bundle\SurveyBundle;

use Ekyna\Bundle\CoreBundle\AbstractBundle;
use Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler\AdminMenuPass;
use Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler\AnswerTypeRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaSurveyBundle
 * @package Ekyna\Bundle\SurveyBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSurveyBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminMenuPass());
        $container->addCompilerPass(new AnswerTypeRegistryPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelInterfaces()
    {
        return array(
            'Ekyna\Bundle\SurveyBundle\Model\SurveyInterface'   => 'ekyna_survey.survey.class',
            'Ekyna\Bundle\SurveyBundle\Model\QuestionInterface' => 'ekyna_survey.question.class',
            'Ekyna\Bundle\SurveyBundle\Model\ResultInterface'   => 'ekyna_survey.result.class',
            'Ekyna\Bundle\SurveyBundle\Model\AnswerInterface'   => 'ekyna_survey.answer.class',
        );
    }
}
