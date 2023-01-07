<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\BDProva;
use App\Entity\Contacte;
use App\Entity\Comarca;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContacteType;

class ContacteController extends AbstractController
{
    private $contactes;
    public function __construct(BDProva $dades)
    {
        $this->contactes = $dades->get();
    }

    #[Route('/contacte/{codi}' ,name:'fitxa_contacte', requirements: ['codi' => '\d+'])]
    public function fitxa($codi, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Contacte::class);
        $contacte = $repositori->find($codi);
        if ($contacte)
            return $this->render('fitxa_contacte.html.twig',
                array('contacte' => $contacte));
        else
            return $this->render('fitxa_contacte.html.twig',
                array('contacte' => NULL));
    }

    #[Route('/contacte/nou', name:'nou_contacte')]
    public function nou(Request $request, ManagerRegistry $doctrine)
    {
        $contacte = new Contacte();
        /*$contacte->setNom("Frank Gallagher");
        $contacte->setTelefon("659231544");
        $contacte->setEmail("frank@simarro.org");*/
        $formulari = $this->createForm(ContacteType::class, $contacte);
        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $contacte = $formulari->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contacte);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('nou.html.twig',
            array('formulari' => $formulari->createView()));
    }

    #[Route('/contacte/editar/{codi}', name:'editar_contacte', requirements: ['codi' => '\d+'])]
    public function editar(Request $request, $codi, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Contacte::class);
        $contacte = $repositori->find($codi);
        $formulari = $this->createForm(ContacteType::class, $contacte);
        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid())
        {
            $contacte = $formulari->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contacte);
            $entityManager->flush();
            return $this->redirectToRoute('inici');
        }
        return $this->render('editar.html.twig',
            array('formulari' => $formulari->createView()));
    }

    #[Route('/contacte/inserir', name:'inserir_contacte')]
    public function inserir(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $repositori = $doctrine->getRepository(Comarca::class);
        $comarca = $repositori->find(1);
        $contacte = new Contacte();
        $contacte->setNom("Gus Grimly");
        $contacte->setTelefon("665990014");
        $contacte->setEmail("gusgrimly@fargo.com");
        $contacte->setComarca($comarca);
        $entityManager->persist($comarca);
        $entityManager->persist($contacte);
        try {
            $entityManager->flush();
            return new Response("Contacte inserit amb id " . $contacte->getId());
        } catch (\Exception $e) {
            return new Response("Error inserint objecte");
        }
        //return new Response("Contacte inserit amb id " . $contacte->getId());
    }

    #[Route('/contacte/actualitzar', name:'actualitzar_contacte')]
    public function actualitzar(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $repositori = $doctrine->getRepository(Contacte::class);
        $contacte = $repositori->find(1);
        if ($contacte)
        {
            $contacte->setNom("Molly Solverson");
            $contacte->setTelefon("693154755");
            $contacte->setEmail("mollysolverson@simarro.org");
            try {
                $entityManager->flush();
                return new Response("Contacte actualitzat amb id " . $contacte->getId());
            } catch (\Exception $e) {
                return new Response("Error actualitzant objecte");
            }
        }
    }

    #[Route('/contacte/esborrar/{codi}', name:'esborrar_contacte', requirements: ['codi' => '\d+'])]
    public function esborrar($codi, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $repositori = $doctrine->getRepository(Contacte::class);
        $contacte = $repositori->find($codi);
        if ($contacte)
        {
            $entityManager->remove($contacte);
            try {
                $entityManager->flush();
                return new Response("Contacte esborrat amb id " . $codi);
            } catch (\Exception $e) {
                return new Response("Error esborrant objecte");
            }
        }


    }

    #[Route('/contacte/{text}' ,name:'buscar_contacte')]
    public function buscar($text, ManagerRegistry $doctrine)
    {
        $repositori = $doctrine->getRepository(Contacte::class);
        $resultat = $repositori->findByName($text);
        return $this->render('llista_contactes.html.twig', array(
            'contactes' => $resultat
        ));
    }

}
?>