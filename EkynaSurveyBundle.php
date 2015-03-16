<?php

namespace Ekyna\Bundle\SurveyBundle;

use Ekyna\Bundle\SurveyBundle\DependencyInjection\Compiler\AdminMenuPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaSurveyBundle
 * @package Ekyna\Bundle\SurveyBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSurveyBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AdminMenuPass());
    }
}
