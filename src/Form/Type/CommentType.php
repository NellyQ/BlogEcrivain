<?php

namespace BlogEcrivain\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('com_author', TextType::class, array(
                    'required'    => true,
                    'constraints' => array(
                        new Assert\NotBlank(), 
                        new Assert\Length(array(
                        'min' => 2,'max' => 100,
                        ))),
            ))
            
            ->add('parent_id', TextType::class, array (
                'label' => false,
                'attr' => array('class' => 'parentId') 
            ))
            
            ->add('com_level', TextType::class, array (
                'label' => false,
                'attr' => array('class' => 'comLevel') 
            ))
        
            ->add('com_content', TextareaType::class, array(
                    'required'    => true,
                    'constraints' => array(
                        new Assert\NotBlank(), 
                        new Assert\Length(array(
                        'min' => 5,'max' => 500,
                        ))),
            ));
            
    }

    public function getName()
    {
        return 'comment';
    }
}
