<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Class YesOrNoAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class YesOrNoAnswerType extends AbstractAnswerType
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var array
     */
    private $choices = array(
        'yes' => 'ekyna_core.value.yes',
        'no'  => 'ekyna_core.value.no',
    );


    /**
     * Constructor.
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('value', 'choice', array(
            'label' => $question->getContent(),
            'choices' => $this->choices,
            'expanded' => true,
            'attr' => array('class' => 'inline'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context)
    {
        if (!in_array($answer->getValue(), array_keys($this->choices), true)) {
            $context->addViolationAt('value', 'ekyna_survey.answer.bool_value_is_mandatory');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswersResults(QuestionInterface $question, EntityManagerInterface $em)
    {
        $results = parent::getAnswersResults($question, $em);

        foreach (array_keys($this->choices) as $key) {
            foreach ($results as $result) {
                if ($result['content'] == $key) {
                    continue 2;
                }
            }
            array_push($results, array(
                'content' => $key,
                'num'     => 0,
            ));
        }

        foreach ($results as &$result) {
            $result['content'] = $this->translator->trans(
                $this->choices[$result['content']]
            );
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixtureData(AnswerInterface $answer, $faker)
    {
        $answer->setValue(50 < rand(0, 100) ? 'no' : 'yes');
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.yes_or_no';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'yes_or_no';
    }
}
