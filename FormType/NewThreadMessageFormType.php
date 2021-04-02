<?php

declare(strict_types=1);

namespace FOS\MessageBundle\FormType;

use FOS\MessageBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Message form type for starting a new conversation.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recipient', LegacyFormHelper::getType('FOS\UserBundle\Form\Type\UsernameFormType'), [
                'label' => 'recipient',
                'translation_domain' => 'FOSMessageBundle',
            ])
            ->add('subject', LegacyFormHelper::getType(TextType::class), [
                'label' => 'subject',
                'translation_domain' => 'FOSMessageBundle',
            ])
            ->add('body', LegacyFormHelper::getType(TextareaType::class), [
                'label' => 'body',
                'translation_domain' => 'FOSMessageBundle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'intention' => 'message',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'fos_message_new_thread';
    }
}
