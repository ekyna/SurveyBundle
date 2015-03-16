<?php

namespace Ekyna\Bundle\SurveyBundle\Controller;

use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CompleteController
 * @package Ekyna\Bundle\SurveyBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class CompleteController extends Controller
{
    /**
     * Renders the complete action.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completeAction(Request $request)
    {
        /** @var \Ekyna\Bundle\SurveyBundle\Entity\Survey $survey */
        $survey = $this
            ->get('ekyna_survey.survey.repository')
            ->findOneBy(['slug' => $request->attributes->get('slug')])
        ;
        if (null === $survey) {
            throw new NotFoundHttpException('Survey not found.');
        }

        $complete = $this->get('ekyna_survey.complete_factory')->get($survey, array(
            '_footer' => array(
                'buttons' => array(
                    'submit' => array(
                        'theme' => 'primary',
                        'icon' => 'ok',
                        'label' => 'ekyna_core.button.validate',
                    )
                )
            ),
        ));
        if ($complete->handleRequest($request)) {
            $this->addFlash('Bravo !', 'success');

            return $this->redirect($this->generateUrl('ekyna_survey_complete', ['slug' => $survey->getSlug()]));
        }

        return $this->render('EkynaSurveyBundle:Complete:complete.html.twig', array(
            'survey' => $survey,
            'form'   => $complete->getForm()->createView(),
        ));
    }
}
