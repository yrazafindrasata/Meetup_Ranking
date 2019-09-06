<?php


namespace App\Manager;


use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConferenceManager
{
    private $repository;
    private $em;

    public function __construct( ConferenceRepository $repository,EntityManagerInterface $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    public function getVotedConference()
    {
        return $this->repository->findBy([
            'published'=>true,
        ]);
    }

    public function getNotVotedConference($idCategory)
    {
        return $this->repository->findBy([
            'published'=>true,
            'category'=>$idCategory,
        ]);
    }

}