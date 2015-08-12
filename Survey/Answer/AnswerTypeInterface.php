<?php

namespace Ekyna\Bundle\SurveyBundle\Survey\Answer;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\SurveyBundle\Model\AnswerInterface;
use Ekyna\Bundle\SurveyBundle\Model\QuestionInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Interface AnswerTypeInterface
 * @package Ekyna\Bundle\SurveyBundle\Survey\Answer
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface AnswerTypeInterface
{
    /**
     * Builds the answer form.
     *
     * @param FormInterface     $form
     * @param QuestionInterface $question
     */
    public function buildForm(FormInterface $form, QuestionInterface $question);

    /**
     * Validates the answer.
     *
     * @param AnswerInterface           $answer
     * @param ExecutionContextInterface $context
     */
    public function validate(AnswerInterface $answer, ExecutionContextInterface $context);

    /**
     * Builds the question's answers chart.
     *
     * @param QuestionInterface      $question
     * @param EntityManagerInterface $em
     */
    public function buildChart(QuestionInterface $question, EntityManagerInterface $em);

    /**
     * Returns whether the answer requires at least one choice.
     *
     * @return integer
     */
    public function requireChoices();

    /**
     * Loads the fixture answer data.
     *
     * @param AnswerInterface $answer
     * @param \Faker\Generator $faker
     */
    public function loadFixtureData(AnswerInterface $answer, $faker);

    /**
     * Returns the type label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns the type name.
     *
     * @return string
     */
    public function getName();
}
