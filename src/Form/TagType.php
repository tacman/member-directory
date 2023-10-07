<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tagName')
            ->add('members', CollectionType::class, [
                'label' => false,
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Member::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                            ->join('m.status', 's')
                            ->addOrderBy('s.label', 'ASC')
                            ->addOrderBy('m.lastName', 'ASC')
                            ->addOrderBy('m.preferredName', 'ASC')
                        ;
                    },
                    'group_by' => function ($choice, $key, $value) {
                        return $choice->getStatus()->getLabel();
                    },
                    'attr' => [
                        'class' => 'selectpicker',
                        'data-live-search' => true,
                        'title' => 'Search for Member ...',
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
