<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 06.10.2017
 * Time: 18:23
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Bass;
use AppBundle\Form\Type\BassType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FindmybassController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage")
     */
    public function indexAction(){

        $basses = $this->getDoctrine()
                        ->getRepository("AppBundle:Bass")
                        ->findAll();

        return $this->render("findmybass/index.html.twig", [
            "basses" => $basses
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/addbass", name="addbass")
     */
    public function addbassAction(Request $request){
        $form = $this->createForm(BassType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//            TODO check db for make name and model name and return objects; if not, create new makes/models
//            TODO add objects IDs to the Bass object created by the form
//            TODO add create/modify date and other details to bass object
//            TODO persist bass object to database and redirect to details page
//            $em = $this->getDoctrine()->getManager();
//            $bass = $form->getData();

            dump($form->getData());
            exit();

        }
        return $this->render("findmybass/addbass.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/allbasses", name="allbasses")
     */
    public function allbassesAction(){
        $basses = $this->getDoctrine()
                       ->getRepository("AppBundle:Bass")
                       ->findAll();

        return $this->render("findmybass/allbasses.html.twig", [
            "basses" => $basses
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/userprofile", name="userprofile")
     */
    public function profileAction(){
        return $this->render("findmybass/userprofile.html.twig");
    }
}