<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use App\Repository\SubTopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(TopicRepository $repo, SubTopicRepository $repoSubTopic , Request $request, ObjectManager $manager)
    {
        $topics = $repo->findAll();
        
        return $this->render('blog/index.html.twig', [
            'topics' => $topics
        ]);
    }
}
