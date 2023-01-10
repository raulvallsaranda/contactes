<?php
namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Comarca;
class ContacteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('nom', TextType::class)
            ->add('telefon', TextType::class)
            ->add('email', EmailType::class, array('label' => 'Correu Electrònic'))
            ->add('comarca', EntityType::class, array('class' => Comarca::class,'choice_label' => 'nom',))
            ->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}
?>