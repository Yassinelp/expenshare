<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Expense;
use App\Entity\Person;
use App\Entity\ShareGroup;
use Symfony\Component\HttpFoundation\Request;
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
            ->innerJoin('e.person', 'p')
            ->innerJoin('e.category', 'c')
            ->where('p.shareGroup = :group')
            ->setParameter(':group' , $shareGroup)
            ->getQuery()
            ->getArrayResult()
        ;

        return $this->json($expenses);
    }

    /**
     * @Route("/", name="expense_new", methods="POST")
     */
    public function new(Request $request)
    {
        $data = $request->getContent();

        $jsonData = json_decode($data, true);

        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository(Category::class)->find($jsonData["cat"]);
        $person = $em->getRepository(Person::class)->find($jsonData["person"]);

        $expense = new Expense();
        $expense->setTitle($jsonData["title"]);
        $expense->setAmount($jsonData["amount"]);
        $expense->setCreatedAt(new \DateTime());
        $expense->setCategory($category);
        $expense->setPerson($person);

        $em->persist($expense);
        $em->flush();

        $exp = $this->getDoctrine()->getRepository(Expense::class)
            ->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter(':id', $expense->getId())
            ->getQuery()
            ->getArrayResult();

        return $this->json($exp[0]);
    }
}
