<?php

namespace Ekyna\Bundle\SurveyBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\Context;
use Ekyna\Bundle\AdminBundle\Controller\Resource\TinymceTrait;
use Ekyna\Bundle\AdminBundle\Controller\ResourceController;

/**
 * Class SurveyController
 * @package Ekyna\Bundle\SurveyBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyController extends ResourceController
{
    use TinymceTrait;
}
