<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class QuestionRepository
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class QuestionRepository extends EntityRepository
{
    /**
     * Creates a new question.
     *
     * @return \Ekyna\Bundle\SurveyBundle\Model\QuestionInterface
     */
    public function createNew()
    {
        $class = $this->getClassName();
        return new $class;
    }
}
