<?php

namespace Ekyna\Bundle\SurveyBundle\EventListener;

use Ekyna\Bundle\AdminBundle\Event\ResourceMessage;
use Ekyna\Bundle\SurveyBundle\Entity\ResultRepository;
use Ekyna\Bundle\SurveyBundle\Event\SurveyEvent;
use Ekyna\Bundle\SurveyBundle\Event\SurveyEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SurveyEventSubscriber
 * @package Ekyna\Bundle\SurveyBundle\EventListener
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ResultRepository
     */
    private $resultRepository;

    /**
     * Constructor.
     *
     * @param ResultRepository $resultRepository
     */
    public function __construct(ResultRepository $resultRepository)
    {
        $this->resultRepository = $resultRepository;
    }

    /**
     * Survey pre update event handler.
     *
     * @param SurveyEvent $event
     */
    public function onPreUpdate(SurveyEvent $event)
    {
        $survey = $event->getSurvey();

        if (null !== $result = $this->resultRepository->findOneBy(['survey' => $survey])) {
            $event->addMessage(new ResourceMessage('ekyna_survey.survey.alert.update_prevented', ResourceMessage::TYPE_WARNING));
            $event->stopPropagation();
        }
    }

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            SurveyEvents::PRE_UPDATE => array('onPreUpdate', -1024),
        );
    }
}
