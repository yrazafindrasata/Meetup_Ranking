<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Note;
use App\Form\AddConferenceType;
use App\Form\NoteType;
use App\Form\UpdateConferenceType;
use App\Repository\ConferenceRepository;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function AllConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {
        $allConference =$conferenceRepository->findAllC();
        for($i=0;$i<count($allConference);$i++){
            $notes = [];
            $notes=$noteRepository->findByIdConference($allConference[$i]['id']);
            $addNote=0;
            if(!empty($notes)) {
                foreach ($notes as $key){
                    $addNote=$addNote+$key['value'];
                }
                $moyen = $addNote / count($notes);
                $allConference[$i]['moyenne']=$moyen;
            }else{
                $allConference[$i]['moyenne']="non noté";
            }
        }
        return $this->render('home/index.html.twig', [
            'conferences' => $allConference,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {

        $name=$_GET['name'];
        $allConference =$conferenceRepository->search($name);
        for($i=0;$i<count($allConference);$i++){
            $notes = [];
            $notes=$noteRepository->findByIdConference($allConference[$i]['id']);
            $addNote=0;
            if(!empty($notes)) {
                foreach ($notes as $key){
                    $addNote=$addNote+$key['value'];
                }
                $moyen = $addNote / count($notes);
                $allConference[$i]['moyenne']=$moyen;
            }else{
                $allConference[$i]['moyenne']=0;
            }
        }
        return $this->render('home/index.html.twig', [
            'conferences' => $allConference,
        ]);
    }
    /**
     * @Route("/admin/conference", name="adminConference")
     */
    public function AllAdminConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {
        $allConference =$conferenceRepository->findAllC();
        for($i=0;$i<count($allConference);$i++){
            $notes = [];
            $notes=$noteRepository->findByIdConference($allConference[$i]['id']);
            $addNote=0;
            if(!empty($notes)) {
                foreach ($notes as $key){
                    $addNote=$addNote+$key['value'];
                }
                $moyen = $addNote / count($notes);
                $allConference[$i]['moyenne']=$moyen;
            }else{
                $allConference[$i]['moyenne']="non noté";
            }
        }
        return $this->render('home/index.html.twig', [
            'conferences' => $allConference,
        ]);
    }

    /**
     * @Route("/admin/conference/top10", name="adminConferenceTop")
     */
    public function topConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {
        $allConference =$conferenceRepository->findAllC();
        for($i=0;$i<count($allConference);$i++){
            $notes = [];
            $notes=$noteRepository->findByIdConference($allConference[$i]['id']);
            $addNote=0;
            if(!empty($notes)) {
                foreach ($notes as $key){
                    $addNote=$addNote+$key['value'];
                }
                $moyen = $addNote / count($notes);
                $allConference[$i]['moyenne']=$moyen;
            }else{
                $allConference[$i]['moyenne']=0;
            }
        }
        array_multisort( array_column($allConference, "moyenne"), SORT_DESC, $allConference );
        return $this->render('conference/top10.html.twig', [
            'conferences' => $allConference,
        ]);
    }




    /**
     * @Route("/profile/conference/notVoted", name="conferenceNotVoted")
     */
    public function AllNotVotedConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {
        $idUser=$_GET['id'];
        $notes=$noteRepository->findAllArray();

        $noteUser=[];
        for($i=0;$i<count($notes);$i++){
            if($notes[$i]['user']['id']==$idUser){
                $noteUser[]=$notes[$i];
            }
        }

        if(!empty($noteUser)) {
            $allconf = $conferenceRepository->findAllC();
            $conferences = [];
            for ($i = 0; $i < count($allconf); $i++) {
                $trouve=false;
                for ($j = 0; $j < count($noteUser); $j++) {
                    if ($allconf[$i]['id'] == $noteUser[$j]['conference']['id']) {
                        $trouve=true;
                    }
                }
                if($trouve==false){
                    $conferences[] = $allconf[$i];
                }
            }
        }else{
            $conferences =$conferenceRepository->findAllC();
        }

        for($i=0;$i<count($conferences);$i++){
            $notesConference=$noteRepository->findByIdConference($conferences[$i]['id']);
            $addNote=0;
            if(!empty($notesConference)) {
                foreach ($notesConference as $key){
                    $addNote=$addNote+$key['value'];
                }
                $moyenne = $addNote / count($notesConference);
                $conferences[$i]['moyenne']=$moyenne;
            }else{
                $conferences[$i]['moyenne']="non noté";
            }
        }


        return $this->render('conference/conferenceNotVoted.html.twig', [
            'conferences' => $conferences,
        ]);
    }
    /**
     * @Route("/profile/conference/voted", name="conferenceVoted")
     */
    public function AllVotedConference(NoteRepository $noteRepository, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {
        $idUser=$_GET['id'];
        $notes=$noteRepository->findAllArray();
        $noteUser=[];
        for($i=0;$i<count($notes);$i++){
            if($notes[$i]['user']['id']==$idUser){
                $notesConference=$noteRepository->findByIdConference($notes[$i]['conference']['id']);
                $addNote=0;
                if(!empty($notesConference)) {
                    foreach ($notesConference as $key){
                        $addNote=$addNote+$key['value'];
                    }
                    $moyenne = $addNote / count($notesConference);
                    $notes[$i]['conference']['moyenne']=$moyenne;
                }else{
                    $notes[$i]['conference']['moyenne']="non noté";
                }
                $noteUser[]=$notes[$i];
            }
        }
        return $this->render('conference/conferenceVoted.html.twig', [
            'notes' => $noteUser,
        ]);
    }

    /**
     * @Route("/profile/conference/add", name="addConference")
     */
    public function addConference(Request $request,ConferenceRepository $conferenceRepository,UserRepository $userRepository,EntityManagerInterface $em)
    {
        $id=$_GET['id'];
        $user =$userRepository->find($id);
        $conference =new Conference();
        $conference->setUser($user);
        $form = $this->createForm(AddConferenceType::class,$conference);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()) {
            $em->persist($conference);
            $em->flush();
            return $this->redirectToRoute('home');
        }


        return $this->render('conference/addConference.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/profile/conference/{id}", name="seeConference")
     */
    public function seeConference(Request $request,Conference $conference,NoteRepository $noteRepository,EntityManagerInterface $em, ConferenceRepository $conferenceRepository, UserRepository $userRepository)
    {

        $idConference=$_GET['idC'];
        $idUser=$_GET['idU'];
        $user =$userRepository->find($idUser);
        $conference=$conferenceRepository->find($idConference);
        $notesByconfe=$noteRepository->findByIdConference($idConference);
        $idUserFind=false;
        if(!empty($notesByconfe)){
            $i=0;
            while($idUserFind==false && $i<count($notesByconfe)){
                if($idUser==$notesByconfe[$i]["user"]['id']){
                    $idUserFind=true;
                    $key=$i;
                }
                $i++;
            }
        }
        if($idUserFind==false){
            $note =new Note();
            $note->setUser($user);
            $note->setConference($conference);
            $form = $this->createForm(NoteType::class,$note);
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()) {
                $conference->setEval(1);
                $em->persist($conference);
                $em->persist($note);
                $em->flush();
            }
        }else{
            $note=$noteRepository->find($notesByconfe[$key]['id']);
            $form = $this->createForm(NoteType::class,$note);
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid()) {
                $em->persist($note);
                $em->flush();
            }
        }


        $notes=$noteRepository->findByIdConference($idConference);
        $addNote=0;
        if(!empty($notes)) {
            foreach ($notes as $key){
                $addNote=$addNote+$key['value'];
            }
            $moyenne = $addNote / count($notes);
        }else{
            $moyenne="non noté";
        }

        return $this->render('conference/conference.html.twig', [
            'conference' => $conference,
            'moyenne'=>$moyenne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/conference/remove/{id}", name="conference_remove")
     */
    public function remove(Conference $conference, EntityManagerInterface $entityManager )
    {
        $entityManager ->remove($conference);
        $entityManager ->flush();
        return $this->redirectToRoute('adminConference');
    }

    /**
     * @Route("/admin/conference/patch/{id}", name="conference_patch")
     */
    public function patchConference(Request $request, Conference $conference, EntityManagerInterface $em )
    {
        $form = $this->createForm(UpdateConferenceType::class,$conference);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $em->persist($conference);
            $em->flush();
        }
        return $this->render('conference/addConference.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    function multi_unique($src){
        $output = array_map("unserialize",
            array_unique(array_map("serialize", $src)));
        return $output;
    }
}
