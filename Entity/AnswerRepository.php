<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class AnswerRepository
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AnswerRepository extends EntityRepository
{
    /**
     * Creates a new answer.
     *
     * @return \Ekyna\Bundle\SurveyBundle\Model\AnswerInterface
     */
    public function createNew()
    {
        $class = $this->getClassName();
        return new $class;
    }
}
