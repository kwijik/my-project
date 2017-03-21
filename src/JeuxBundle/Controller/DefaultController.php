<?php

namespace JeuxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('JeuxBundle:Default:index.html.twig');
    }

    public function helloAction($name)
    {
        return $this->render('JeuxBundle:Default:helloAction.html.twig', ["name"=>$name]);
    }

    public function birthdayAction($monthInLetters, $day)
    {
        $months = [0 => 'janvier', 1 => 'fevrier', 2 => 'mars', 3 => 'avril', 4 => 'mai', 5 => 'juin', 6 => 'juillet', 7 => 'aout', 8 => 'septembre', 9 => 'octobre', 10 => 'novembre', 11 => 'decembre'];

        $date = new DateTime();
        $year = $date->format('Y');
        // $actualDay = $date.format('d');
        // $actualMonth = $date.format('m');
        $month = array_search(strtolower($monthInLetters), $months);
        $thisBirth = new DateTime(); // date of birh of current year

        $thisBirth->setDate($year, $month, $day);

        $hadBirth = 0;

        if ($date->diff($thisBirth)->invert == 1){
            $hadBirth = 1;
        }

        $output = '<ul>';

        for ($i = 0; $i < 10; $i++){
            $y = $year + $hadBirth +$i;
            $date->setDate($y,  (int)$month,(int) $day);
            $day = $date->format('l');
            $output .= "<li> $y: $day </li>";
        }

        $output .= '</ul>';

        return new Response(
            '<html><body>Days of Birth for 10 years: '.$output.'</body></html>'
        );
    }
}
