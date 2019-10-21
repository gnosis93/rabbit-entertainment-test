<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){
          // 1) build the form
          $user = new User();
          $form = $this->createForm(UserForm::class, $user);
  
          // 2) handle the submit (will only happen on POST)
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
  
              // 3) Encode the password (you could also do this via Doctrine listener)
              $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
              $user->setPassword($password);
  
              // 4) save the User!
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($user);
              $entityManager->flush();
  
              // ... do any other work - like sending them an email, etc
              // maybe set a "flash" success message for the user
  
              return $this->redirectToRoute('login');
          }
  
          return $this->render(
              'security/register.html.twig',
              array('form' => $form->createView())
          );
    }

}
