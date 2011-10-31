<?php

namespace JGI\Bundle\MessyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use JGI\Bundle\MessyBundle\DependencyInjection\Compiler\TaggedProvidersPass;

class JGIMessyBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TaggedProvidersPass());
    }
}
