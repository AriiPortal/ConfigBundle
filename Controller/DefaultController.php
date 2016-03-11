<?php

namespace Arii\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiConfigBundle:Default:index.html.twig');
    }

    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiConfigBundle:Default:ribbon.json.twig',array(), $response );
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setCharset('UTF-8');
        
        return $this->render('AriiConfigBundle:Default:menu_tree.json.twig',array(), $response );
    }
    
    public function readmeAction()
    {
        return $this->render('AriiConfigBundle:Default:readme.html.twig');
    }

    public function phpinfoAction()
    {
        phpinfo();
        exit();
    }

    public function save_dbAction()
    {
        $mysql = $this->container->getParameter('mysql');
        
        $descriptorspec = array(
            0 => array("pipe", "r"),  // // stdin est un pipe où le processus va lire
            1 => array("pipe", "w"),  // stdout est un pipe où le processus va écrire
            2 => array("pipe", "w") // stderr est un fichier
         );
        
        $user =     $this->container->getParameter('database_user');    
        $password = $this->container->getParameter('database_password');
        $host =     $this->container->getParameter('database_host');
        $database = $this->container->getParameter('database_name');
        $workspace= $this->container->getParameter('workspace');  
        @mkdir("$workspace/Config");
        $dump = "$workspace/Config/mysqldump_$database.sql";
        $cmd = "$mysql/mysqldump  --user=$user --password=$password --host=$host $database > $dump";
        // print "<pre>$cmd</pre>";
        print "<h1>Dump $database</h1>";
        print "<table>";
        print "<tr><th>User</th><td>$user</td></tr>";
        print "<tr><th>Host</th><td>$host</td></tr>";
        
        $process = proc_open($cmd, $descriptorspec, $pipes);
        
        if (is_resource($process)) {
            fwrite($pipes[0], '' );
            fclose($pipes[0]);

            $out = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $err = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $return_value = proc_close($process);
            
            print "[exit $return_value]<br/>";
            print "$out<br/>";
            print "<font color='red'>$err</font>";            
        }  
        $fp = fopen( $dump, "r");
        $fstat = fstat($fp);
        fclose($fp);
        print "<tr><th>Date</th><td>".gmdate("Y-m-d H:i:s", $fstat['mtime'])." o</td></tr>";
        print "<tr><th>Size</th><td>".$fstat['size']." o</td></tr>";        
        
        print "</table>";
        exit();
    }

}
