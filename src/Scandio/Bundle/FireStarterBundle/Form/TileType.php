<?php

namespace Scandio\Bundle\FireStarterBundle\Form;

use Scandio\Bundle\FireStarterBundle\Entity\Tile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TileType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('type', 'choice', array(
                'choices' => array(
                    Tile::TYPE_DEFAULT => 'Default',
                    Tile::TYPE_WIDGET => 'Widget'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Scandio\Bundle\FireStarterBundle\Entity\Tile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'scandio_bundle_firestarterbundle_tile';
    }
}
