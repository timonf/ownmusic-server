<?php

namespace ServerBundle\Form\Type;

use ServerBundle\Form\Model\UploadRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('files', FileType::class, [
            'label' => false,
            'multiple' => true,
            'required' => true,
            'attr' => [
                'accept' => 'audio/*',
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadRequest::class,
        ]);
    }
}
