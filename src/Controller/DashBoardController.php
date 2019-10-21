<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\File;
use App\Form\FileUploadForm;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DashBoardController extends Controller
{
    public function indexAction(Request $request, FileUploader $fileUploader,EntityManagerInterface $em)
    {
        $form = $this->createForm(FileUploadForm::class);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $fileRepository = $em->getRepository(File::class);

            $uploadedTextFile = $form['fileUpload']->getData();
            $fileUploader->upload($uploadedTextFile,$fileRepository);
        }
        
        return $this->render('dashboard/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    // public function uploadFileAction(){
        
    // }
}