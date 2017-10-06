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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/addbass", name="addbass")
     */
    public function addbassAction(){
        return $this->render("findmybass/addbass.html.twig");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/allbasses", name="allbasses")
     */
    public function allbassesAction(){
        return $this->render("findmybass/allbasses.html.twig");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/userprofile", name="userprofile")
     */
    public function profileAction(){
        return $this->render("findmybass/userprofile.html.twig");
    }
}