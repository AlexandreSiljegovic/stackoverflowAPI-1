<?php

namespace App\Controller;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // Parse JSON data from the request body
        $jsonData = json_decode($request->getContent(), true);

        // Create a new Member entity
        $member = new Member();
        $member->setRegistrationDate(new \DateTime());

        // Set Member properties from JSON data
        $member->setUsername($jsonData['username']);
        $member->setEmail($jsonData['email']);
        $member->setFirstName($jsonData['first_name']);
        $member->setLastName($jsonData['last_name']);

        // Hash the password
        $member->setPassword(
            $userPasswordHasher->hashPassword(
                $member,
                $jsonData['password']
            )
        );

        // Persist the Member entity
        $entityManager->persist($member);
        $entityManager->flush();

        // Return a JSON response
        return new JsonResponse(['message' => 'User registered successfully'], JsonResponse::HTTP_CREATED);
    }
}