<?php
namespace TS\ControlBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use TS\ControlBundle\Controller\MainController;

class PreActionListener
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container     = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }
        
        if ($controller[0] instanceof MainController) {
        	$tournamentUrl = $this->container->get('request')->get('tournamentUrl', '');
            $controller[0]->setTournament($tournamentUrl);
        }
    }
}