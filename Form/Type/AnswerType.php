<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Ekyna\Bundle\SurveyBundle\Model\QuestionTypes;
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
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $form = $event->getForm();
                /** @var \Ekyna\Bundle\SurveyBundle\Entity\Question $question */
                $question = $event->getData()->getQuestion();
                QuestionTypes::isValid($question->getType(), true);

                if ($question->getType() === QuestionTypes::MULTIPLE_CHOICES) {
                    $form->add('choices', 'entity', array(
                        'label' => $question->getContent(),
                        'choices' => $question->getChoices()->toArray(),
                        'class' => 'Ekyna\Bundle\SurveyBundle\Entity\Choice',
                        'expanded' => true,
                        'multiple' => true,
                    ));
                } else {
                    $form->add('choice', 'entity', array(
                        'label' => $question->getContent(),
                        'choices' => $question->getChoices()->toArray(),
                        'class' => 'Ekyna\Bundle\SurveyBundle\Entity\Choice',
                        'expanded' => true,
                        'multiple' => false,
                    ));
                }
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
                'data_class' => 'Ekyna\Bundle\SurveyBundle\Entity\Answer',
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
