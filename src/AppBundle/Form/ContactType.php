<?php

namespace AppBundle\Form;

use AppBundle\Contact\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'form.placeholder.contact.name'],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'form.placeholder.contact.email'],
            ])
            ->add('subject', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'form.placeholder.contact.subject'],
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'form.placeholder.contact.content'],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'form.placeholder.contact.send',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
