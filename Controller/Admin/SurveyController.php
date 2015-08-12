<?php

namespace Ekyna\Bundle\SurveyBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\Context;
use Ekyna\Bundle\AdminBundle\Controller\Resource\TinymceTrait;
use Ekyna\Bundle\AdminBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

/**
 * Class SurveyController
 * @package Ekyna\Bundle\SurveyBundle\Controller\Admin
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SurveyController extends ResourceController
{
    use TinymceTrait;

    /**
     * Survey reset action.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetAction(Request $request)
    {
        $context = $this->loadContext($request);

        $resourceName = $this->config->getResourceName();
        $resource = $context->getResource($resourceName);

        $this->isGranted('DELETE', $resource);

        $form = $this->createResetForm($context);

        $form->handleRequest($request);
        if ($form->isValid()) {

            $dql = sprintf(
                'DELETE FROM %s r WHERE r.survey = :survey',
                $this->container->getParameter('ekyna_survey.result.class')
            );
            $query = $this->getManager()->createQuery($dql);
            $query
                ->setParameter('survey', $resource)
                ->execute()
            ;

            $this->addFlash('ekyna_survey.survey.message.reset', 'info');

            if (null !== $redirectPath = $form->get('_redirect')->getData()) {
                return $this->redirect($redirectPath);
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if ($form->get('actions')->get('resetAndList')->isClicked()) {
                if ($this->hasParent()) {
                    $redirectPath = $this->generateUrl(
                        $this->getParent()->getConfiguration()->getRoute('show'),
                        $context->getIdentifiers()
                    );
                } else {
                    $redirectPath = $this->generateResourcePath($resource, 'list');
                }
            } elseif (null === $redirectPath = $form->get('_redirect')->getData()) {
                $redirectPath = $this->generateResourcePath($resource);
            }
            return $this->redirect($redirectPath);
        }

        $this->appendBreadcrumb(
            sprintf('%s-remove', $resourceName),
            'ekyna_survey.survey.button.reset'
        );

        return $this->render(
            $this->config->getTemplate('reset.html'),
            $context->getTemplateVars(array(
                'form' => $form->createView()
            ))
        );
    }

    /**
     * Creates the reset form.
     *
     * @param Context $context
     * @return \Symfony\Component\Form\Form
     */
    protected function createResetForm(Context $context)
    {
        $resource = $context->getResource();

        $action = $this->generateResourcePath($resource, 'reset');

        $referer = $context->getRequest()->headers->get('referer');
        if (0 < strlen($referer) && false === strpos($referer, $action)) {
            $cancelPath = $referer;
        } else {
            if ($this->hasParent()) {
                $cancelPath = $this->generateUrl(
                    $this->getParent()->getConfiguration()->getRoute('show'),
                    $context->getIdentifiers()
                );
            } else {
                $cancelPath = $this->generateResourcePath($resource);
            }
        }

        $form = $this
            ->createFormBuilder(null, array(
                'action' => $action,
                'attr' => array('class' => 'form-horizontal'),
                'method' => 'POST',
                'admin_mode' => true,
                '_redirect_enabled' => true,
            ))
            ->add('confirm', 'checkbox', array(
                'label' => 'ekyna_survey.survey.message.reset_confirm',
                'attr' => array('align_with_widget' => true),
                'required' => true,
                'constraints' => array(
                    new Constraints\True(),
                )
            ))
            ->add('actions', 'form_actions', [
                'buttons' => [
                    'resetAndList' => [
                        'type' => 'submit',
                        'options' => [
                            'button_class' => 'danger',
                            'label' => 'ekyna_core.button.reset_and_list',
                            'attr' => ['icon' => 'list'],
                        ],
                    ],
                    'reset' => [
                        'type' => 'submit',
                        'options' => [
                            'button_class' => 'danger',
                            'label' => 'ekyna_core.button.reset',
                            'attr' => ['icon' => 'ok'],
                        ],
                    ],
                    'cancel' => [
                        'type' => 'button',
                        'options' => [
                            'label' => 'ekyna_core.button.cancel',
                            'button_class' => 'default',
                            'as_link' => true,
                            'attr' => [
                                'class' => 'form-cancel-btn',
                                'icon' => 'remove',
                                'href' => $cancelPath,
                            ],
                        ],
                    ],
                ],
            ])
            ->getForm();

        return $form;
    }
}
