<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Entity\ShareGroup;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExpenseController
 * @package App\Controller
 * @Route("/expense")
 */
class ExpenseController extends BaseController
{
    /**
     * @Route("/group/{slug}", name="expense", methods="GET")
     */
    public function index(ShareGroup $shareGroup)
    {
        $expenses = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->select('e', 'p', 'c')
            ->leftJoin('e.person', 'p')
            ->leftJoin('e.category', 'c')
            ->where('p.shareGroup = :group')
            ->setParameter(':group' , $shareGroup)
            ->getQuery()
            ->getArrayResult()
        ;

        return $this->json($expenses);
    }
}
