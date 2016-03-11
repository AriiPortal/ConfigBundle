<?php

namespace Arii\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RepositoryeController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiConfigBundle:Repository:index.html.twig');
    }

    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiConfigBundle:Default:ribbon.json.twig',array(), $response );
    }

    public function readmeAction()
    {
        return $this->render('AriiConfigBundle:Default:readme.html.twig');
    }
    
}
