<?php

namespace AppBundle\Model;

class UploadImage
{
    private   $item;
    private   $container;
    protected $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em        = $this->container->get('doctrine')->getEntityManager();
    }

    public function upload($item)
    {
        $this->item = $item;
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $this->item->getPath();

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move(
            $this->container->getParameter('image_directory'),
            $fileName
        );

        $this->item->setPath($fileName);
        $this->em->persist($this->item);
        $this->em->flush();
    }
}
