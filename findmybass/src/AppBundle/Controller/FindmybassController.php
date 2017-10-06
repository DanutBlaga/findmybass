<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 06.10.2017
 * Time: 18:23
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FindmybassController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function indexAction(){
        return $this->render("findmybass/index.html.twig");
    }
}