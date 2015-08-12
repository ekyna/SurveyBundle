<?php

namespace Ekyna\Bundle\SurveyBundle\Survey;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Entity\Answer;
use Ekyna\Bundle\SurveyBundle\Entity\ResultRepository;
use Ekyna\Bundle\SurveyBundle\Entity\Survey;
use Ekyna\Bundle\SurveyBundle\Event\ResultEvent;
use Ekyna\Bundle\SurveyBundle\Event\ResultEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class CompleteFactory
 * @package Ekyna\Bundle\SurveyBundle\Survey
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class CompleteFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var ResultRepository
     */
    private $resultRepository;


    /**
     * Constructor.
     *
     * @param FormFactoryInterface     $formFactory
     * @param EntityManagerInterface   $manager
     * @param EventDispatcherInterface $dispatcher
     * @param ResultRepository         $repository
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        ResultRepository $repository
    ) {
        $this->formFactory      = $formFactory;
        $this->manager          = $manager;
        $this->dispatcher       = $dispatcher;
        $this->resultRepository = $repository;
    }

    /**
     * Creates and returns the survey complete.
     *
     * @param Survey $survey
     * @param array $formOptions
     * @return Complete
     */
    public function get(Survey $survey, array $formOptions = array())
    {
        $result = $this->resultRepository->createNew();
        $result
            ->setSurvey($survey)
            ->setDate(new \DateTime())
        ;
        foreach ($survey->getQuestions() as $question) {
            $answer = new Answer();
            $answer->setQuestion($question);
            $result->addAnswer($answer);
        }

        $this->dispatcher->dispatch(ResultEvents::INITIALIZED, new ResultEvent($result));

        $form = $this->formFactory
            ->create('ekyna_survey_result', $result, $formOptions)
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'validate' => [
                        'type' => 'submit', 'options' => [
                            'button_class' => 'primary',
                            'label' => 'ekyna_core.button.validate',
                            'attr' => [
                                'icon' => 'ok',
                            ],
                        ],
                    ],
                ],
            ])
        ;

        return new Complete($result, $form, $this->manager, $this->dispatcher);
    }
}
