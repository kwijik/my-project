<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/hello/{prenom}")
     */
    public function helloAction($prenom) {
        return $this->render('default/helloUser.html.twig', [
                    'name' => $prenom,
        ]);
    }

    /**
     * @Route(
     * "/birthday/{month}/{day}",
     * requirements={ "month": "[a-zA-Z_]\w*","day": "\d+" })
     */
    public function yourBirthdayAction($month, $day) {
        $weekays = [];
        $year = date('y');
        $birthday = new \DateTime($year . '-' . $month . '-' . $day);

        for ($i = 0; $i < 10; $i++) {
            $weekays[$year + $i] = $birthday->format('l');
            $birthday->modify('+1 years');
        }
        return $this->render('default/birthday.html.twig', [
                    'weekays' => $weekays,
        ]);
    }

}
