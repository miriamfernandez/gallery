<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 03/08/2016
 * Time: 14:36
 */

namespace AppBundle\Event;

use AppBundle\Entity\Item;
use Symfony\Component\EventDispatcher\Event;

class ItemEvent extends Event
{
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getItem()
    {
        return $this->item;
    }
}