<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpendingRepository")
 */
class Spending
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="text", length=100)
     */
    private $category;

     /**
     * @ORM\Column(type="integer")
     */
    private $summ;

    /**
     * @ORM\Column(type="text")
     */
    private $type;

     /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="date")
     */
    private $date;
 
     /**
     * @ORM\Column(type="integer")
     */
    private $month;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCategory(){
         return $this->category;
    }

    public function setCategory($category){
         $this->category = $category;
    }

        public function getSumm(){
            return $this->summ;
        }

        public function setSumm($summ){
            $this->summ = $summ;
        }

            public function getComment(){
                return $this->comment;
            }

            public function setComment($comment){
                $this->comment = $comment;
            }

             public function getType(){
                 return $this->type;
             }
                public function setType($type){
                    $this->type = $type;
                }

                public function getDate(){
                    return $this->date;
                }
                   public function setDate(){
                       $this->date = new \DateTime(date('d.m.Y'));
                   }

                   public function getMonth(){
                    return $this->month;
                  }
                   public function setMonth(){
                       $this->month = date('m');
                   }
}
