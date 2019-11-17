<?php

namespace App\Form;

use App\Entity\SubTopic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label'  => 'Sujet'])
            /*
            ->add('createdAt')
            ->add('idTopic')
            ->add('idUser')
            ->add('topic')
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubTopic::class,
        ]);
    }
}
