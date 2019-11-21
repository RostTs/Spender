<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Spending;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MoneyController extends Controller
{
  /*--------------------------------------
           СОХРАНЯЕТ ДАННЫЕ В БД
  ----------------------------------------*/
  public function saveExpenses(Request $request){
      $entityManager = $this->getDoctrine()->getManager();
    $type = "Spending";
    $repository = $this->getDoctrine()->getRepository(Categories::class);
    $expCat = $repository->getCategories($type);
     foreach($expCat as $category){
      $summ = $request->get($category->category);
      if(!empty($summ)){
        $spending = new Spending();
        $spending->setCategory($category->category);
        $spending->setSumm($summ);
        $spending->setType($type);
        $spending->setComment(0);
        $spending->setDate();
        $spending->setMonth();


        $entityManager->persist($spending);
        $entityManager->flush();
      }
     };
     $data = array(
      'date' => date('d.m.Y'),
      'successMessage' => 'Вы успешно сохранили новые данные!'
    );       
    return $this->render('pages/index.html.twig',$data);
  }
  /*--------------------------------------
           СОХРАНЯЕТ ДАННЫЕ В БД
  ----------------------------------------*/
  public function saveIncome(Request $request){
    $entityManager = $this->getDoctrine()->getManager();
  $type = "Income";
  $repository = $this->getDoctrine()->getRepository(Categories::class);
  $incCat = $repository->getCategories($type);
   foreach($incCat as $category){
    $summ = $request->get($category->category);
    if(!empty($summ)){
      $spending = new Spending();
      $spending->setCategory($category->category);
      $spending->setSumm($summ);
      $spending->setType($type);
      $spending->setComment(0);
      $spending->setDate();
      $spending->setMonth();

      $entityManager->persist($spending);
      $entityManager->flush();
    }
   };
   $data = array(
    'date' => date('d.m.Y'),
    'successMessage' => 'Вы успешно сохранили новые данные!'
  );       
  return $this->render('pages/index.html.twig',$data);

  return new Response('ewqe');
} 

   /*----------------------------------------------
           ОТВЕЧАЕТ ЗА ПОКАЗ СТАТИСТИКИ
  ------------------------------------------------*/
  public function showStats(){
    $repositorySpen = $this->getDoctrine()->getRepository(Spending::class); // Включает в себя и доходы и расходы
    $repositoryCat = $this->getDoctrine()->getRepository(Categories::class);
     $spenCategories = $repositoryCat->getCategories('Spending');
     $totalSpen = array();                                                   // ВСЕ РАСХОДЫ ПО КАТЕГОРИЯМ 
     $totalInc = array();                                                    // ВСЕ ДОХОДЫ ПО КАТЕГОРИЯМ 
     $month = date('m');

     foreach($spenCategories as $spenCat){
        $cat = $spenCat->getCategory();
        $data = $repositorySpen->getData('Spending',$cat,$month);
        $catSumm = array();
        foreach($data as $single){
          $summ = $single->getSumm();
          array_push($catSumm,$summ);
        }
        $catTotal = array_sum($catSumm);
        $totalSpen[$cat] = $catTotal;
     }


     $incCategories = $repositoryCat->getCategories('Income');
     foreach($incCategories as $incCat){
        $cat = $incCat->getCategory();
        $data = $repositorySpen->getData('Income',$cat,$month);
        $catSumm = array();
        foreach($data as $single){
          $summ = $single->getSumm();
          array_push($catSumm,$summ);
        }
        $catTotal = array_sum($catSumm);
        $totalInc[$cat] = $catTotal;
     }
     
     $days = array();                                             // Содержит в себе все дни в которые велись записи
     $allNotes = $repositorySpen->getDataByMonth($month);
     foreach($allNotes as $note){
      $day = $note->getDate()->format('Y-m-d');
     
      array_push($days,$day);
     }
     
     $days = array_unique($days);

     $dataPointsInc = array();                                   // Все доходы по дням
     $dataPointsSpen = array();                                  // Все расходы по дням
 
     foreach($days as $day){
     $dayInc = $repositorySpen->getDataByDay($day,'Income');
     $daySpen = $repositorySpen->getDataByDay($day,'Spending');

     $dayTotalInc = array();
     $dayTotalSpen = array();
      foreach($dayInc as $one){
        $money = $one->getSumm();
        array_push($dayTotalInc, $money);
      }
      foreach($daySpen as $one){
        $money = $one->getSumm();
        array_push($dayTotalSpen, $money);
      }
        $dayTotalInc = array_sum($dayTotalInc);
        $dayTotalSpen = array_sum($dayTotalSpen);

     $dayDataInc = array("label"=> $day, "y"=> $dayTotalInc);
     $dayDataSpen = array("label"=> $day, "y"=> $dayTotalSpen);
     array_push($dataPointsInc,$dayDataInc);
     array_push($dataPointsSpen,$dayDataSpen);
    } 
    

 // Массивы с информацией для отправки к графикам
    $dataSpen = array(
      array("label"=> "Еда", "y"=> $totalSpen['Еда']),
      array("label"=> "Одежда", "y"=> $totalSpen['Одежда']),
      array("label"=> "Развлечения", "y"=> $totalSpen['Развлечения']),
      array("label"=> "Транспорт", "y"=> $totalSpen['Транспорт']),
      array("label"=> "Спорт", "y"=> $totalSpen['Спорт']),
      array("label"=> "Аренда", "y"=> $totalSpen['Аренда']),
      array("label"=> "Бытовые расходы", "y"=> $totalSpen['Бытовые расходы']),
      array("label"=> "Кредиты", "y"=> $totalSpen['Кредиты']),
      array("label"=> "Другое", "y"=> $totalSpen['Другое'])
    );

    $dataInc = array(
      array("label"=> "Зарплата", "y"=> $totalInc['Зарплата']),
      array("label"=> "Дивиденды", "y"=> $totalInc['Дивиденды']),
      array("label"=> "Подарки", "y"=> $totalInc['Подарки']),
      array("label"=> "Прибыль от бизнеса", "y"=> $totalInc['Прибыль от бизнеса ']),
      array("label"=> "Стипендия", "y"=> $totalInc['Стипендия']),
      array("label"=> "Другое", "y"=> $totalInc['Другое'])
    );

    $jsonSpen = json_encode($dataSpen, JSON_NUMERIC_CHECK);
    $jsonInc = json_encode($dataInc, JSON_NUMERIC_CHECK);
    $jsonDaySpen = json_encode($dataPointsInc, JSON_NUMERIC_CHECK);
    $jsonDayInc = json_encode($dataPointsSpen, JSON_NUMERIC_CHECK);

    $data = array(
      'date' => date('d.m.Y'),
       'jsonIncome' => $jsonInc,
       'jsonExpenses' => $jsonSpen,
       'jsonDaySpen' => $jsonDaySpen,
       'jsonDayInc' => $jsonDayInc
    );      
    return $this->render('pages/stats.html.twig',$data);

  }
}