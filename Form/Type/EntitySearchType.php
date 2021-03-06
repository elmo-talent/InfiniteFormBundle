<?php

namespace Infinite\FormBundle\Form\Type;

use Infinite\FormBundle\Form\DataTransformer\EntitySearchTransformerFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntitySearchType extends AbstractType
{
    /**
     * @var EntitySearchTransformerFactory
     */
    private $transformerFactory;

    public function __construct(EntitySearchTransformerFactory $transformerFactory)
    {
        $this->transformerFactory = $transformerFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', 'text', array('required' => $options['required']))
            ->setAttribute('search_route', $options['search_route'])
            ->addModelTransformer($this->transformerFactory->createFromOptions($options))
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['search_route'] = $form->getConfig()->getAttribute('search_route');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_not_found' => false,
            'error_bubbling' => false,
            'invalid_message' => 'Item not found',
            'name' => null,
            'search_route' => null,
        ));

        $resolver->setRequired(array(
            'class'
        ));
    }

    public function getName()
    {
        return 'infinite_form_entity_search';
    }
}
