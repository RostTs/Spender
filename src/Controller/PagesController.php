<?php

namespace App\Controller;

use App\Entity\Categories;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    // Все категории расходов
    public $categoriesSpending = array(
        'Еда',
        'Одежда',
        'Развлечения',
        'Транспорт',
        'Спорт',
        'Аренда',
        'Бытовые расходы',
        'Кредиты',
        'Другое'
        
    );

    // Все категории доходов
    public $categoriesIncome = array(
        'Зарплата',
        'Дивиденды',
        'Подарки',
        'Прибыль от бизнеса ',
        'Стипендия',
        'Другое'
    );
      /*--------------------------------------
          Возвращает на главную страницу
      ----------------------------------------*/
    public function home()
    {
        $data = array(
            'date' => date('d.m.Y')
        );
     return $this->render('pages/index.html.twig', $data);
    }

    /*--------------------------------------
     Возвращает на страницу выбора типа записи
      ----------------------------------------*/
    public function createPage(){
        $entityManager = $this->getDoctrine()->getManager();
        $cat = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        if(empty($cat)){
               foreach($this->categoriesSpending as $catSpend){
                $categories = new Categories();
                    $categories->setCategory($catSpend);
                    $categories->setType('Spending');

                    $entityManager->persist($categories);
                    $entityManager->flush();
               }

                foreach($this->categoriesIncome as $catInc){
                    $categories = new Categories();
                    $categories->setCategory($catInc);
                    $categories->setType('Income');

                    $entityManager->persist($categories);
                    $entityManager->flush();
                }
        } 
        $data = array(
            'date' => date('d.m.Y')
        );       
        return $this->render('pages/create.html.twig',$data);
    }

    /*--------------------------------------
       Возвращает на страницу записи расходов
      ----------------------------------------*/
    public function noteExpenses(){
         $type = "Spending";
         $repository = $this->getDoctrine()->getRepository(Categories::class);
         $spenCat = $repository->getCategories($type);
         $message = "Здесь вы можете записать свои расходы за день";
         $data = array(
            'date' => date('d.m.Y'),
            'categories' => $spenCat,
            'message' => $message,
            'action' => 'saveExpenses'
        );  
        return $this->render('pages/note.html.twig',$data);
    }

     /*--------------------------------------
       Возвращает на страницу записи доходов
      ----------------------------------------*/
    public function noteIncome(){
        $type = "Income";
        $repository = $this->getDoctrine()->getRepository(Categories::class);
        $incCat = $repository->getCategories($type);
        $message = "Здесь вы можете записать свои доходы за день";
        $data = array(
           'date' => date('d.m.Y'),
           'categories' => $incCat,
           'message' => $message,
           'action' => 'saveIncome'
       );  
        return $this->render('pages/note.html.twig',$data);
    }
}