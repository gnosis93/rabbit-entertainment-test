<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileController extends Controller
{

    public function listingAction(Request $request,EntityManagerInterface $entityManager)
    {
        $fileRepository = $this->getFileRepository($entityManager);

        $files = $fileRepository->getAllFiles();

        return $this->render('file/listing.html.twig', array(
            'files' => $files
        ));
    }

    public function fileCardsAction(Request $request,EntityManagerInterface $entityManager,int $fileId){
        $fileRepository = $this->getFileRepository($entityManager);

        $file = $fileRepository->getFileById($fileId);
        if(!$file){
            throw new HttpException(404,"File Not Found");
        }
        
        return $this->render('file/hand-listing.html.twig', array(
            'hands' => $file->hands->getValues()
        ));
    }


    private function getFileRepository($entityManager):FileRepository{
        return $entityManager->getRepository(File::class);
    }
}