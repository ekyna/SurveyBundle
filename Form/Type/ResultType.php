<?php

namespace Ekyna\Bundle\SurveyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ResultType
 * @package Ekyna\Bundle\SurveyBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ResultType extends AbstractType
{
    /**
     * @var string
     */
    private $kernelEnvironment;


    /**
     * Constructor.
     *
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->kernelEnvironment = $environment;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answers', 'collection', array(
                'label' => false,
                'type'  => 'ekyna_survey_answer',
            ))
        ;

        if ($this->kernelEnvironment !== 'test') {
            $builder->add('captcha', 'ekyna_captcha');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'label' => false,
                'data_class' => 'Ekyna\Bundle\SurveyBundle\Entity\Result',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_survey_result';
    }
}
