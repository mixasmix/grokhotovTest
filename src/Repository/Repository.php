<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

interface Repository
{
    public function add(object $entity, bool $isFlush = false): object;

    public function getRepository(): EntityRepository;
}
