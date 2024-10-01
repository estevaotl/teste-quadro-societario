<?php

namespace App\Form;

use App\Entity\Empresa;
use App\Entity\Socio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SocioForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'O nome é obrigatório.']),
                ],
            ])
            ->add('cpf', TextType::class)
            ->add('empresa', EntityType::class, [
                'class' => Empresa::class,
                'choice_label' => 'nome',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}

?>