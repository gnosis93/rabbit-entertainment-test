<?php
// src/Repository/UserRepository.php
namespace App\Repository;

use App\Entity\File;
use App\Entity\Hand;
use Doctrine\ORM\EntityRepository;

class FileRepository extends EntityRepository
{

    public function getAllFiles(){
        return $this->findAll();
    }

    public function getFileById(int $id):?File{
        return $this->findOneBy([
            'id' => $id
        ]);
    }

    public function saveUploadedFile($fileName, array $processedFile)
    {
        $entityManager =  $this->getEntityManager();

        $fileInDb = $this->newFile($fileName);
        $entityManager->persist($fileInDb);

        $hands = [];
        foreach ($processedFile as $hand) { 
           $dbHand = $this->newHand($hand,$fileInDb);
           if(!$dbHand){
               continue;
           }
           
           $entityManager->persist($dbHand);
           $hands[] = $dbHand; 
        }

        $entityManager->flush();
    }

    private function newHand(array $handInFile,File $fileInDb){
        $handInDb = new Hand();
        foreach($handInFile as $key=>$card){
            if(!$card){
                return null;
            }
            $cardColumnName = 'card_'.($key+1);
            $handInDb->$cardColumnName = trim($card);
        }

        $handInDb->file = $fileInDb;
        return $handInDb;
    }

    private function newFile($fileName )
    {
        $file = new File();
        $file->name = $fileName;
        $file->postedAt = new \DateTime();

        return $file;
    }
}
