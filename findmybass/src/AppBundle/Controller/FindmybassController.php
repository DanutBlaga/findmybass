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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/addbass", name="addbass")
     */
    public function addbassAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(BassType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
//          TODO cleanup this stuff, put in separate controller
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

            $user = $this
                ->getDoctrine()
                ->getRepository(Users::class)
                ->find(1);

            $bass->setUserEntity($user);  //TODO make dynamics between bass and user
            $em->persist($bass);
            $em->flush();

            return $this->redirectToRoute("allbasses"); //TODO set redirect
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