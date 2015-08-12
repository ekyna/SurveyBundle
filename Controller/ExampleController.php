<?php

namespace Ekyna\Bundle\SurveyBundle\Controller;

use Ekyna\Bundle\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ExampleController
 * @package Ekyna\Bundle\SurveyBundle\Controller
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ExampleController extends Controller
{
    /**
     * Example complete page.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completeAction(Request $request)
    {
        $survey = $this->get('ekyna_survey.survey.repository')->findCurrent();

        if (null !== $survey) {
            $complete = $this->get('ekyna_survey.complete_factory')->get($survey, array(
                'action' => $this->generateUrl('ekyna_survey_example_complete'),
                'method' => 'post',
                'attr' => array('class' => 'form'),
            ));
            if ($complete->handleRequest($request)) {
                $this->addFlash('Bravo !', 'success');

                return $this->redirect($this->generateUrl('ekyna_survey_example_complete'));
            }
            $formView = $complete->getForm()->createView();
        } else {
            $formView = null;
        }

        return $this->render('EkynaSurveyBundle:Example:complete.html.twig', array(
            'survey' => $survey,
            'form'   => $formView,
        ));
    }
}
