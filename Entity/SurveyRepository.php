<?php

namespace Ekyna\Bundle\SurveyBundle\Entity;

use Doctrine\DBAL\Types\Type;
use Ekyna\Bundle\AdminBundle\Doctrine\ORM\ResourceRepository;

/**
 * Class SurveyRepository
 * @package Ekyna\Bundle\SurveyBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyRepository extends ResourceRepository
{
    /**
     * Returns the current survey.
     *
     * @return Survey|null
     */
    public function findCurrent()
    {
        $dql = 'SELECT s FROM %s s WHERE :now BETWEEN s.startDate AND s.endDate ORDER BY s.startDate ASC';

        $query = $this
            ->getEntityManager()
            ->createQuery(sprintf($dql, $this->getClassName()))
        ;

        return $query
            ->setMaxResults(1)
            ->setParameter('now', new \DateTime(), Type::DATETIME)
            ->getOneOrNullResult()
        ;
    }
}
