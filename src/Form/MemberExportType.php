<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\MemberStatus;
use App\Entity\Tag;
use App\Repository\MemberStatusRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberExportType extends AbstractType
{
    protected $memberStatusRepository;

    protected $tagRespository;

    public function __construct(MemberStatusRepository $memberStatusRepository, TagRepository $tagRespository)
    {
        $this->memberStatusRepository = $memberStatusRepository;
        $this->tagRepository = $tagRespository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('default_filters', CheckboxType::class, [
                'label' => 'Apply default filters',
                'required' => false,
                'data' => true,
                'help' => 'Excludes: Do Not Contact, Lost, Deceased'
            ])
            ->add('mailable', CheckboxType::class, [
                'label' => 'Mailable',
                'required' => false,
                'help' => 'Excludes: Blank Address Line 1'
            ])
            ->add('emailable', CheckboxType::class, [
                'label' => 'E-mailable',
                'required' => false,
                'help' => 'Excludes: Empty E-mail Address'
            ])
        ;

        if (count($this->memberStatusRepository->findAll())) {
            $builder->add('statuses', EntityType::class, [
                'class' => MemberStatus::class,
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ]);
        }

        if (count($this->tagRepository->findAll())) {
            $builder->add('tags', EntityType::class, [
                'class' => Tag::class,
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ]);
        }
    }
}
