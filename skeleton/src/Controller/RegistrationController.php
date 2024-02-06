<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Member;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $member = new Member();
        $member->setRegistrationDate(new \DateTime());
        $form = $this->createForm(RegistrationFormType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $member->setPassword(
                $userPasswordHasher->hashPassword(
                    $member,
                    $form->get('plainPassword')->getData()
                )
            );


            $entityManager->persist($member);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
