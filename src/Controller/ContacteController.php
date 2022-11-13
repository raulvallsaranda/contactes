<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ContacteController
{
    private $contactes = array(
        array("codi" => 1, "nom" => "Salvador Sala",
            "telefon" => "638961244", "email" => "salvasala@simarro.org"),
        array("codi" => 2, "nom" => "Anna Llopis",
            "telefon" => "669332004", "email" => "annallopis@simarro.org"),
        array("codi" => 3, "nom" => "Marc Sanchis",
            "telefon" => "962286040", "email" => "marcsanchis@simarro.org"),
        array("codi" => 4, "nom" => "Laura Palop",
            "telefon" => "663568890", "email" => "laurapalop@simarro.org"),
        array("codi" => 5, "nom" => "Sara Sidle",
            "telefon" => "638765434", "email" => "sarasidle@simarro.org"),
    );
    #[Route('/contacte/{codi}' ,name:'fitxa_contacte', requirements: ['codi' => '\d+'])]
    public function fitxa($codi = 1)
    {
        $resultat = array_filter($this->contactes,
            function($contacte) use ($codi)
            {
                return $contacte["codi"] == $codi;
            });
        if (count($resultat) > 0)
        {
            $resposta = "";
            $resultat = array_shift($resultat); #torna el primer element
            $resposta .= "<ul><li>" . $resultat["nom"] . "</li>" .
                "<li>" . $resultat["telefon"] . "</li>" .
                "<li>" . $resultat["email"] . "</li></ul>";
            return new Response("<html><body>$resposta</body></html>");
        }
        else
            return new Response("Contacte no trobat");
    }

    #[Route('/contacte/{text}' ,name:'buscar_contacte')]
    public function buscar($text)
    {
        $resultat = array_filter($this->contactes,
            function($contacte) use ($text)
            {
                return strpos($contacte["nom"], $text) !== FALSE;
            });
        $resposta = "";
        if (count($resultat) > 0)
        {
            foreach ($resultat as $contacte)
                $resposta .= "<ul><li>" . $contacte["nom"] . "</li>" .
                    "<li>" . $contacte["telefon"] . "</li>" .
                    "<li>" . $contacte["email"] . "</li></ul>";
            return new Response("<html><body>" . $resposta . "</body></html>");
        }
        else
            return new Response("No s'han trobat contactes");
    }

}
?>