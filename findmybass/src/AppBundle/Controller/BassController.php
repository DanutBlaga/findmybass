<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Bass;
use AppBundle\Entity\Make;
use AppBundle\Entity\Model;
use AppBundle\Entity\UserRatings;
use AppBundle\Entity\Users;
use AppBundle\Form\Type\BassEditType;
use AppBundle\Form\Type\BassType;
use AppBundle\Utils\StringNormalizer;
use AppBundle\Utils\ThumbsArray;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BassController extends Controller {

    /**
     * @Route("/bass/details/{id}", name="bassdetails")
     */
    public function bassDetailsAction($id) {
        $bass = $this->getDoctrine()
            ->getRepository('AppBundle:Bass')->
            find($id);

        return $this->render('findmybass/details.html.twig', [
           'bass' => $bass
        ]);
    }

    /**
     * @Route("/bass/edit/{id}", name="bassedit")
     */
    public function bassEditAction($id, Request $request) {

        $bass = $this->getDoctrine()
            ->getRepository('AppBundle:Bass')
            ->find($id);

        $bass->setYear($bass->getYear());
        $bass->setManufacturingPlace($bass->getManufacturingPlace());
        $bass->setCurrentLocation($bass->getCurrentLocation());
        $bass->setDescription($bass->getDescription());

        $form = $this->createForm(BassEditType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $year = $form['Year']->getData();
            $currentLocation = $form['CurrentLocation']->getData();
            $manufacturingPlace = $form['manufacturingPlace']->getData();
            $description = $form['Description']->getData();

            $em = $this->getDoctrine()->getManager();
            $bass = $em->getRepository('AppBundle:Bass')->find($id);

            $bass->setYear($year);
            $bass->setCurrentLocation($currentLocation);
            $bass->setManufacturingPlace($manufacturingPlace);
            $bass->setDescription($description);

            $em->flush();

            return $this->redirectToRoute("allbasses");
        }

        return $this->render('findmybass/edit.html.twig',[
            'form' => $form->createView(),
            'bass' => $bass
        ]);
    }

    /**
     * @Route("/bass/delete/{id}", name="bassdelete")
     */
    public function bassDeleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $bass = $em->getRepository('AppBundle:Bass')->find($id);

        $em->remove($bass);
        $em->flush();

        $this->addFlash(
            'notice',
            'Bass deleted'
        );

        return $this->redirectToRoute('allbasses');

        //return $this->render('findmybass/delete.html.twig');
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

    /**
     * @Route("/bass/thumbsUp/{id}", name="bassthumbsup")
     * @Method({"POST"})
     * @param Request $request
     * @return string
     */
    public function thumbsUpAction(Request $request, $id) {

        $user = $this->getUser();

        if ($user instanceof Users) {


            $em = $this->getDoctrine()->getManager();

            $bass = $em->getRepository('AppBundle:Bass')->find($id);

            $userRating = $em->getRepository('AppBundle:UserRatings')->findOneBy([
                'userID' => $user->getId(),
                'bassID' => $bass->getId()
            ]);
            if (null == $userRating) {
                $rating = $bass->getRating();
                $rating += 1;

                $bass->setRating($rating);

                // TODO Create constructors for userRating, one empty, one w/ bass 'n user
                $userRating = new UserRatings();
                $userRating->setBass($bass);
                $userRating->setBassID($bass->getId());
                $userRating->setUser($user);
                $userRating->setUserID($user->getId());
                $userRating->setIsThumbsUp(true);

                $em->persist($userRating);
                $em->flush();

                $array = ThumbsArray::getJSONArray(true, $rating);
            }
            else {
                $array = ThumbsArray::getJSONArray(false, "You have already given a thumbsUp.");
            }
        }
        else {
            $array = ThumbsArray::getJSONArray(false, "You must be logged in to give a thumbsUp.");
        }

        return new JsonResponse($array);
    }

    /**
     * @Route("/bass/thumbsDown/{id}", name="bassthumbsdown")
     * @Method({"POST"})
     * @param Request $request
     * @return string
     */
    public function thumbsDownAction(Request $request, $id) {

        $user = $this->getUser();

        if ($user instanceof Users) {

            $em = $this->getDoctrine()->getManager();

            $bass = $em->getRepository('AppBundle:Bass')->find($id);

            $userRating = $em->getRepository('AppBundle:UserRatings')->findOneBy([
                'userID' => $user->getId(),
                'bassID' => $bass->getId()
            ]);

            if (null == $userRating) {
                $rating = $bass->getRating();
                $rating-=1;

                $bass->setRating($rating);

                $userRating = new UserRatings();
                $userRating->setBass($bass);
                $userRating->setBassID($bass->getId());
                $userRating->setUser($user);
                $userRating->setIsThumbsUp(false);

                $em->persist($userRating);
                $em->flush();

                $array = ThumbsArray::getJSONArray(true, $rating);
            }

            else {
                $array = ThumbsArray::getJSONArray(false, "You have already given a thumbsDown.");
            }
        }
        else {
            $array = ThumbsArray::getJSONArray(false, "You need to be logged in to give a thumbsDown.");
        }

        return new JsonResponse($array);
    }
}