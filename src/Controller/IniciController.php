<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
class IniciController extends AbstractController
{
    private $logger;
    private $formatData;
    public function __construct(/*LoggerInterface */$logger, $formatData)
    {
        $this->logger = $logger;
        $this->formatData = $formatData;
    }
    #[Route('/', name:'inici')]
    public function inici()
    {
        $data_hora = new \DateTime();
        $this->logger->info("Accés el " .$data_hora->format($this->formatData));
        return $this->render('inici.html.twig',array('data'=>$data_hora->format($this->formatData),
                                                            'data2'=>$this->getParameter('format_data_defecte')));
    }
}
?>