<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ResultRepository
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ResultRepository extends EntityRepository
{
    /**
     * Creates a new result.
     *
     * @return \Ekyna\Bundle\SurveyBundle\Model\ResultInterface
     */
    public function createNew()
    {
        $class = $this->getClassName();
        return new $class;
    }
}
