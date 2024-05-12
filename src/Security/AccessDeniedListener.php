<?php

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class AccessDeniedListener implements EventSubscriberInterface
{
    private $accessDeniedHandler;

    public function __construct(AccessDeniedHandler $accessDeniedHandler)
    {
        $this->accessDeniedHandler = $accessDeniedHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if($exception instanceof AccessDeniedHttpException)
        {
            $exception = $event->getThrowable();
            if ($exception instanceof AccessDeniedHttpException) {
                $this->accessDeniedHandler->handle($event->getRequest(), $exception);
            }
        }
    }
}