<?php


namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Note;
use App\Entity\User;
use App\Form\AddConferenceType;
use App\Form\LoginUserType;
use App\Form\NoteType;
use App\Form\PatchUserType;
use App\Form\RegisterUserType;
use App\Repository\ConferenceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/admin/user/remove/{id}", name="user_remove")
     */
    public function remove(User $user, EntityManagerInterface $entityManager )
    {
        $entityManager ->remove($user);
        $entityManager ->flush();
        return $this->redirectToRoute('allUser');
    }

    /**
     * @Route("/admin/user", name="allUser")
     */
    public function allUser(UserRepository $userRepository)
    {
        $allUser =$userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $allUser,
        ]);
    }

    /**
     * @Route("/admin/user/add", name="user_add")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('allUser');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}