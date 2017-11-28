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
     * @Route("/allbasses", name="allbasses")
     */
    public function allbassesAction(){
        $em = $this->getDoctrine()->getManager();
        $basses = $this->getDoctrine()
                       ->getRepository("AppBundle:Bass")
                       ->findAll();

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