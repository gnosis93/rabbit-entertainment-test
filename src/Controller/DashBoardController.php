<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Form\FileUploadForm;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashBoardController extends Controller
{
    public function indexAction(Request $request, FileUploader $fileUploader)
    {
        $form = $this->createForm(FileUploadForm::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedTextFile = $form['fileUpload']->getData();
            $fileUploader->upload($uploadedTextFile);
        }
        
        return $this->render('dashboard/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    // public function uploadFileAction(){
        
    // }
}