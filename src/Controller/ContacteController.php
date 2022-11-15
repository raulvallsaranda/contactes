<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BDProva;
class ContacteController extends AbstractController
{
    private $contactes;
    public function __construct(BDProva $dades)
    {
        $this->contactes = $dades->get();
    }

    #[Route('/contacte/{codi}' ,name:'fitxa_contacte', requirements: ['codi' => '\d+'])]
    public function fitxa($codi)

    {
        $resultat = array_filter($this->contactes,
            function($contacte) use ($codi)
            {
                return $contacte["codi"] == $codi;
            });
        if (count($resultat) > 0)
            return $this->render('fitxa_contacte.html.twig', array(
                'contacte' => array_shift($resultat)));
        else
            return $this->render('fitxa_contacte.html.twig', array(
                'contacte' => NULL));
    }

    #[Route('/contacte/{text}' ,name:'buscar_contacte')]
    public function buscar($text)
    {
        $resultat = array_filter($this->contactes,
            function($contacte) use ($text)
            {
                return strpos($contacte["nom"], $text) !== FALSE;
            });
        return $this->render('llista_contactes.html.twig',
            array('contactes' => $resultat));
    }

}
?>