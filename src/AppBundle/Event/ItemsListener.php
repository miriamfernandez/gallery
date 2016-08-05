<?php

namespace AppBundle\Event;

use Symfony\Bridge\Monolog\Logger;


class ItemsListener
{
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }
    public function onItemCreate(ItemEvent $event)
    {
        $item = $event->getItem();
        $this->logger->info('Se ha creado el item '.$item->getId());
    }
    public function onItemDelete(ItemEvent $event)
    {
        $item = $event->getItem();
        $this->logger->info('Se ha borrado el item '.$item->getId());
    }
    public function onItemUpdate(ItemEvent $event)
    {
        $item = $event->getItem();
        $this->logger->info('Se ha modificado el item '.$item->getId());
    }
}