<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\SubTopic;
use App\Repository\TopicRepository;
use App\Repository\SubTopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

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
     * @Route("/discussion/creer", name="blog_subtopic_new")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        return $this->render('blog/create.html.twig');
    }

    /**
     * @Route("/discussion/{id}", name="blog_subtopic")
     */
    public function subTopic(SubTopic $subTopic, TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager)
    {
        
        return $this->render('blog/subtopic.html.twig', [
            'subTopic' => $subTopic
        ]);
    }
    /**
     * @Route("/categories/{id}", name="blog_topic", requirements={"id"="^[0-9]+$"})
     */
    public function topic(Topic $topic, TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager)
    {
        
        return $this->render('blog/topic.html.twig', [
            'topic' => $topic
            ]);
        
        
    }

}   