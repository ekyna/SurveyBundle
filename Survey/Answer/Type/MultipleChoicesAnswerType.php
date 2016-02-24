<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class MultipleChoicesAnswerType
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class MultipleChoicesAnswerType extends AbstractChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form, QuestionInterface $question)
    {
        $form->add('choices', 'entity', array(
            'label' => $question->getContent(),
            'choices' => $question->getChoices()->toArray(),
            'class' => 'Ekyna\Bundle\SurveyBundle\Entity\Choice',
            'expanded' => true,
            'multiple' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixtureData(AnswerInterface $answer, $faker)
    {
        $questionChoices = $answer->getQuestion()->getChoices()->toArray();
        $answer->setChoices(new ArrayCollection(
            $faker->randomElements($questionChoices, rand(1, count($questionChoices)))
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'ekyna_survey.question.type.multiple_choices';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'multiple_choices';
    }
}
