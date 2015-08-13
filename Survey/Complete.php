<?php

namespace Ekyna\Bundle\SurveyBundle\Survey;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\ResultInterface;
use Ekyna\Bundle\SurveyBundle\Event\ResultEvent;
use Ekyna\Bundle\SurveyBundle\Event\ResultEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Complete
 * @package Ekyna\Bundle\SurveyBundle\Survey
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Complete
{
    /**
     * @var ResultInterface
     */
    private $result;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;


    /**
     * Constructor.
     *
     * @param ResultInterface          $result
     * @param FormInterface            $form
     * @param EntityManagerInterface   $manager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        ResultInterface          $result,
        FormInterface            $form,
        EntityManagerInterface   $manager,
        EventDispatcherInterface $dispatcher
    ) {
        $this->result     = $result;
        $this->form       = $form;
        $this->manager    = $manager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Returns the result.
     *
     * @return ResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Returns the form.
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Handles the request.
     *
     * @param Request $request
     * @return bool
     */
    public function handleRequest(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $this->form->handleRequest($request);
            if ($this->form->isValid()) {
                $event = new ResultEvent($this->result);

                $this->dispatcher->dispatch(ResultEvents::PRE_PERSIST, $event);

                if (!$event->isPropagationStopped()) {
                    $this->manager->persist($this->result);
                    $this->manager->flush();

                    $this->dispatcher->dispatch(ResultEvents::COMPLETED, $event);

                    return !$event->isPropagationStopped();
                }
            }
        }

        return false;
    }
}
