<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 06.10.2017
 * Time: 18:23
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Bass;
use AppBundle\Entity\Make;
use AppBundle\Entity\Model;
use AppBundle\Entity\Users;
use AppBundle\Form\Type\BassType;
use AppBundle\Form\Type\RegisterType;
use AppBundle\Utils\PasswordUtils;
use AppBundle\Utils\StringNormalizer;
use AppBundle\Utils\UserTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/allbasses/{makeParam}/{modelParam}", name="allbasses", defaults={"makeParam" = 0, "modelParam" = 0})
     */
    public function allbassesAction($makeParam, $modelParam){

        $em = $this->getDoctrine()->getManager();
        $makeDropdownText = "Select Make";
        $modelDropdownText = "Select Model";
        $allModelsOfMake = [];

        if (0 === $makeParam) {
            //there's no make selected in the dropdown filter; select all basses
            $basses = $em
                ->getRepository("AppBundle:Bass")
                ->findAll();

        }
        else {
            $makeDropdownText = $em->getRepository('AppBundle:Make')->find($makeParam)->getName();
            $allModelsOfMake = $em->getRepository('AppBundle:Model')->findBy(
                ['makeID' => $makeParam]
            );

            if (0 === $modelParam) {
                $basses = $em->getRepository('AppBundle:Bass')->findBy(
                  ['makeID' => $makeParam]
                );
            }
            else {
                $modelDropdownText = $em->getRepository('AppBundle:Model')->find($modelParam)->getName();
                $basses = $em->getRepository('AppBundle:Bass')->findBy(
                  [
                      'makeID' => $makeParam,
                      'modelID' => $modelParam
                  ]
                );
            }
        }




        //TODO Move if to separate function
        $user = $this->getUser();
        if ($user instanceof Users) {
            foreach ($basses as $bass) {
                $userRating = $em->getRepository('AppBundle:UserRatings')->findOneBy([
                    'userID' => $user->getId(),
                    'bassID' => $bass->getId()
                ]);

                if (null !== $userRating) {
                    if ($userRating->getIsThumbsUp()) {
                        $bass->setIsThumbsUp();
                    }
                    else {
                        $bass->setIsThumbsDown();
                    }
                }
            }
        }

        $makes = $em->getRepository('AppBundle:Make')->findAll();

        return $this->render("findmybass/allbasses.html.twig", [
            "basses" => $basses,
            "makes" => $makes,
            "models" => $allModelsOfMake,
            "makeDropdownText" => $makeDropdownText,
            "modelDropdownText" => $modelDropdownText
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/userprofile", name="userprofile")
     */
    public function profileAction(){
        return $this->render("findmybass/userprofile.html.twig");
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $pwdEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/userregister", name="userregister")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $pwdEncoder){

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $user->setPassword($pwdEncoder->encodePassword($user, $user->getPassword()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("homepage");
        }
        return $this->render("findmybass/userregister.html.twig", [
            "form" => $form->createView()
        ]);
    }
}