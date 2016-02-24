<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\View;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\SurveyInterface;
use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;

/**
 * Class Builder
 * @package Ekyna\Bundle\SurveyBundle\Survey\View
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Builder
{
    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;

    /**
     * @var EntityManagerInterface
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param AnswerTypeRegistryInterface $registry
     * @param EntityManagerInterface      $manager
     */
    public function __construct(AnswerTypeRegistryInterface $registry, EntityManagerInterface $manager)
    {
        $this->registry = $registry;
        $this->manager = $manager;
    }

    /**
     * Builds the survey view.
     *
     * @param SurveyInterface $survey
     *
     * @return Survey
     */
    public function build(SurveyInterface $survey)
    {
        $resultCount = $this->manager
            ->createQuery(
                'SELECT COUNT(r.id) '.
                'FROM Ekyna\Bundle\SurveyBundle\Entity\Result r ' .
                'WHERE r.survey = :survey'
            )
            ->setParameters(array(
                'survey' => $survey
            ))
            ->getSingleScalarResult();

        $view = new Survey(
            $survey->getTitle(),
            $survey->getDescription(),
            $resultCount
        );

        foreach ($survey->getQuestions() as $question) {
            $type = $this->registry->getType($question->getType());
            $type->fillView($view, $question, $this->manager);
        }

        return $view;
    }
}
