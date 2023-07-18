<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GalleriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('titre', TextType::class, ['required' => true])
            /*->add('categories', EntityType::class, [
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('c')
                    ->leftJoin('categories.titre', 'c', 'WITH', 'images.gallery.id')
                    ;
                },
                'placeholder' => "Choisir une catégorie",
                'choice_label' => 'titre'
            ])*/
            ->add('images', DropzoneType::class,[
                'label' => 'Images',
                /*'data_class'=> null, ne fonctionne pas pour multiples */
                'multiple' => true,
                'mapped' => false,
                'required' => true,
                'help' => 'Attention seulement fichier image .jpeg,.jpg,.png,.gif sera accepté !',
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'mimeTypes' => 'image/*',
                                /* 'maxSize' => '50M', */
                                'mimeTypesMessage' => 'Seulement fichier image accepté : .jpeg,.jpg,.png,.gif, merci de changer de fichier.'
                            ]),
                        ],
                    ])
                ]
            ])
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,//Galleries::class,
        ]);
    }
}
