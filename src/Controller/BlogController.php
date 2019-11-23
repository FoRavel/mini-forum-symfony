<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Message;
use App\Entity\SubTopic;
use App\Form\MessageType;
use App\Form\SubTopicType;
use App\Service\Pagination;
use App\Repository\TopicRepository;
use App\Repository\SubTopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/discussion/{id}/repondre", name="blog_reply")
     */
    public function reply(SubTopic $subTopic, Request $request, ObjectManager $manager, Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("home_bis"));
        $breadcrumbs->addItem("Discussions", $this->get("router")->generate("blog_topic", ['id'=>$subTopic->getTopic()->getId()]));
        $breadcrumbs->addItem("Messages", $this->get("router")->generate("blog_subtopic", ['id'=>$subTopic->getId()]));
        $breadcrumbs->addItem("Répondre");
        
       

        $message = new Message();

        $form = $this->createForm(MessageType::class, $message );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();

            $message->setTopic($subTopic->getTopic());
            $message->setSubTopic($subTopic);
            $message->setIdUser($user);
            $message->setCreatedAt(new \DateTime());

            $manager->persist($message);
            $manager->flush();
        }

        return $this->render('blog/reply.html.twig', [
            'form' => $form->createView() 
        ]);
    }
    
    /**
     * @Route("/categories", name="home_bis")
     * @Route("/", name="home")
     */
    public function home(TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager)
    {
        $topics = $repo->findAll();
        
        return $this->render('blog/index.html.twig', [
            'topics' => $topics
        ]);
    }
    
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/discussion/{id}/creer", name="blog_subtopic_new")
     */
    public function create(Topic $topic, Request $request, ObjectManager $manager)
    {
        $subTopic = new SubTopic();
        $message = new Message();

        $form = $this->createForm(SubTopicType::class, $subTopic);

        $formMessage = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        $formMessage->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();

            $subTopic->setTopic($topic);
            $subTopic->setCreatedAt(new \DateTime());
            $subTopic->setIdUser($user);

            $manager->persist($subTopic);

            $message->setTopic($topic);
            $message->setSubTopic($subTopic);
            $message->setIdUser($user);
            $message->setCreatedAt(new \DateTime());

            $manager->persist($message);
            $manager->flush();
        }
       


        return $this->render('blog/create.html.twig', [
            'formSubTopic' => $form->createView(),
            'formMessage' => $formMessage->createView()
        ]);
    }

    /**
     * @Route("/discussion/{id}", name="blog_subtopic")
     */
    public function subTopic(SubTopic $subTopic, TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager, Breadcrumbs $breadcrumbs)
    {        
        $title = $subTopic->getTopic()->getTitle();
        $titleST = $subTopic->getTitle();
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("home_bis"));
        $breadcrumbs->addItem($title, $this->get("router")->generate("blog_topic", ['id'=>$subTopic->getTopic()->getId()]));
        $breadcrumbs->addItem($titleST);


        $messages = $subTopic->getMessages();

        if(!isset($_GET["page"] )){
            $currentPage = 1;
        }else{
            if(is_numeric($_GET["page"]))
                {$currentPage = $_GET["page"];}
            else
                {$currentPage = 1;}
        }

        $pagination = Pagination::getPagination(10, $messages, $currentPage);
        
        return $this->render('blog/subtopic.html.twig', [
            'subTopic' => $subTopic,
            'pagination' => $pagination
        ]);
    }
    /**
     * @Route("/categories/{id}", name="blog_topic", requirements={"id"="^[0-9]+$"})
     */
    public function topic(Topic $topic, TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager, Breadcrumbs $breadcrumbs)
    {
        $title = $topic->getTitle();
        $breadcrumbs->addItem("Accueil", $this->get("router")->generate("home_bis"));
        $breadcrumbs->addItem($title);
        
        $subTopics = $topic->getSubtopics();

        if(!isset($_GET["page"] )){
            $currentPage = 1;
        }else{
            if(is_numeric($_GET["page"]))
                {$currentPage = $_GET["page"];}
            else
                {$currentPage = 1;}
        }

        $pagination = Pagination::getPagination(10, $subTopics, $currentPage);

        /*
        if(!isset($_GET["page"] )){
            $currentPage = 1;
        }else{
            $currentPage = $_GET["page"];
        }
        var_dump($currentPage );
        $limit = 10;
        $offset = abs($currentPage-1) * $limit;
        $pages = ceil(count($subTopics)/$limit);
        $pagination = array(
            'pages' => $pages,
            'limit' => $limit,
            'offset' => $offset
        );
        var_dump($pagination);
        */

        return $this->render('blog/topic.html.twig', [
            'topic' => $topic,  
            'pagination' =>  $pagination,

            ]);
        
        
    }

}   