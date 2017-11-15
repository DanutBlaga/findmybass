<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Make;
use AppBundle\Entity\Model;
use AppBundle\Form\Type\BassType;
use AppBundle\Utils\StringNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BassController extends Controller {

    /**
     * @Route("/bass/details/{id}", name="bassdetails")
     */
    public function bassDetailsAction($id) {

    }

    /**
     * @Route("/bass/edit/{id}", name="bassedit")
     */
    public function bassEditAction($id) {

    }

    /**
     * @Route("/bass/delete/{id}", name="bassdelete")
     */
    public function bassDeleteAction($id) {

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/addbass", name="addbass")
     */
    public function addbassAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(BassType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $bass = $form->getData();

            $makeEntity = $this->getDoctrine()->getRepository(Make::class)->findOneBy([
                'normalizedName' => StringNormalizer::normalizeName($bass->getMakeName())
            ]);

            if ($makeEntity == null) {
                $makeEntity = new Make();
                $makeEntity->setName($bass->getMakeName());

                $em->persist($makeEntity);
                $em->flush();
            }

            $modelEntity = $this->getDoctrine()->getRepository(Model::class)->findOneBy([
                'makeID' => $makeEntity->getId(),
                'normalizedName' => StringNormalizer::normalizeName($bass->getModelName()),
            ]);

            if ($modelEntity == null) {
                $modelEntity = new Model();
                $modelEntity->setName($bass->getModelName());
                $modelEntity->setMakeID($makeEntity->getId());
                $modelEntity->setMake($makeEntity);

                $em->persist($modelEntity);
                $em->flush();
            }

            $bass->setMake($makeEntity);
            $bass->setMakeID($makeEntity->getId());
            $bass->setModel($modelEntity);
            $bass->setModelID($modelEntity->getId());

            $user = $this->getUser();

            $bass->setUserEntity($user);
            $em->persist($bass);
            $em->flush();

            return $this->redirectToRoute("allbasses");
        }

        return $this->render("findmybass/addbass.html.twig", [
            "form" => $form->createView()
        ]);
    }
}