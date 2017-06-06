<?php

namespace BlogEcrivain\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;


class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('billet_title', TextType::class, array(
                    'required'    => true,
                    'constraints' => array(
                        new Assert\NotBlank(), 
                        new Assert\Length(array(
                        'min' => 5,'max' => 100,
                        ))),
            ))
            ->add('billet_content', TextareaType::class, array(
                    'required'    => true,
                    'constraints' => new Assert\NotBlank(),
            ));
            
    }

    public function getName()
    {
        return 'billet';
    }
}