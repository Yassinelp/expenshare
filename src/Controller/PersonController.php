<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\ShareGroup;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonController
 * @package App\Controller
 * @Route("/person")
 */
class PersonController extends BaseController
{
    /**
     * @Route("/group/{slug}", name="person", methods="GET")
     */
    public function index(ShareGroup $shareGroup)
    {

        $persons = $this->getDoctrine()->getRepository(Person::class)
            ->createQueryBuilder('p')
            ->select('p', 'e')
            ->leftJoin('p.expenses', 'e')
            ->where('p.shareGroup = :group')
            ->setParameter(':group' , $shareGroup)
            ->getQuery()
            ->getArrayResult()
            ;

        return $this->json($persons);

    }
}
