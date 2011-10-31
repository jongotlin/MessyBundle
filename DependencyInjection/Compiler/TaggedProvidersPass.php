<?php

namespace JGI\Bundle\MessyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TaggedProvidersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('jgi_messy.message_center')) {
            return;
        }

        $providers = array();
        foreach ($container->findTaggedServiceIds('messy.provider') as $id => $attributes) 
        {
            $priority = isset($attributes[0]['priority']) ? $attributes[0]['priority'] : 0;
            $providers[$priority][] = new Reference($id);
        }

        // sort by priority and flatten
        krsort($providers);
        $providers = call_user_func_array('array_merge', $providers);

        $def = $container->getDefinition('jgi_messy.message_center');

        foreach($providers as $provider)
        {
            $def->addMethodCall('addProvider', array($provider));
        }
    }
}
