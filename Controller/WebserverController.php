<?php

namespace Arii\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebserverController extends Controller
{
    public function indexAction()
    {
        $Config = array (
            "repository_name" => "Repository name", 
            "repository_dbname" => "Repository database",
            "repository_host" => "Repository host",
            "repository_port" => "Repository port",
            "repository_user" => "Repository user",
            "repository_password" => "Repository password",
            "repository_driver" => "Repository driver",
            "workspace" => "Workspace",
            "site_name" => "Default site",
            "graphviz_dot" => "Graphviz interpreter"
        );
        // On recupere les parametres
        $Render = array();
        foreach ($Config as $k=>$v) {
            $Info['id'] = $k;
            $Info['label'] = $v;
            $Info['value'] = str_replace('\\','/',$this->container->getParameter($k));
            array_push($Render,$Info);
        }
        return $this->render('AriiConfigBundle:Webserver:index.html.twig',array( 'Params' => $Render )  );
    }
}
