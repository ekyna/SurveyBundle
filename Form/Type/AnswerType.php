<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Ekyna\Bundle\SurveyBundle\Survey\Answer\AnswerTypeRegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AnswerType
 * @package Ekyna\Bundle\SurveyBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AnswerType extends AbstractType
{
    /**
     * @var string
     */
    private $dataClass;

    /**
     * @var AnswerTypeRegistryInterface
     */
    private $registry;


    /**
     * Constructor.
     *
     * @param string                      $dataClass
     * @param AnswerTypeRegistryInterface $registry
     */
    public function __construct($dataClass, AnswerTypeRegistryInterface $registry)
    {
        $this->dataClass = $dataClass;
        $this->registry  = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $form = $event->getForm();
                /** @var \Ekyna\Bundle\SurveyBundle\Model\QuestionInterface $question */
                $question = $event->getData()->getQuestion();

                $type = $this->registry->getType($question->getType());
                $type->buildForm($form, $question);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'label' => false,
                'data_class' => $this->dataClass,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey_answer';
    }
}
