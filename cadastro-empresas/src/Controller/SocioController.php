<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Entity\Empresa;
use App\Form\SocioForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/empresa/{empresaId}/socio', name: 'socio_index')]
    public function index(int $empresaId): Response
    {
        // Usando o entity manager injetado para obter os sócios da empresa específica
        $empresa = $this->entityManager->getRepository(Empresa::class)->find($empresaId);
        
        if (!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada.');
        }

        $socios = $empresa->getSocios();

        // Renderizando a view com a lista de sócios
        return $this->render('socio/index.html.twig', [
            'socios' => $socios,
            'empresa' => $empresa,
        ]);
    }

    #[Route('/empresa/{empresaId}/socio/new', name: 'socio_new')]
    public function new(Request $request, int $empresaId): Response
    {
        $empresa = $this->entityManager->getRepository(Empresa::class)->find($empresaId);
        
        if (!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada.');
        }

        $socio = new Socio();
        $socio->setEmpresa($empresa);
        $form = $this->createForm(SocioForm::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($socio);
            $this->entityManager->flush();
            $this->addFlash('success', 'Sócio criado com sucesso!');
            return $this->redirectToRoute('socio_index', ['empresaId' => $empresaId]); // Redireciona para a lista de sócios
        }

        return $this->render('socio/new.html.twig', [
            'form' => $form->createView(),
            'empresa' => $empresa,
        ]);
    }

    #[Route('/empresa/{empresaId}/socio/{id}', name: 'socio_show')]
    public function show(int $empresaId, Socio $socio): Response
    {
        return $this->render('socio/show.html.twig', [
            'socio' => $socio,
            'empresaId' => $empresaId,
        ]);
    }

    #[Route('/empresa/{empresaId}/socio/{id}/edit', name: 'socio_edit')]
    public function edit(Request $request, int $empresaId, Socio $socio): Response
    {
        $form = $this->createForm(SocioForm::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Sócio editado com sucesso!');
            return $this->redirectToRoute('socio_index', ['empresaId' => $empresaId]);
        }

        return $this->render('socio/edit.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio,
            'empresaId' => $empresaId,
        ]);
    }

    #[Route('/empresa/{empresaId}/socio/{id}/delete', name: 'socio_delete')]
    public function delete(int $empresaId, Socio $socio): Response
    {
        $this->entityManager->remove($socio);
        $this->entityManager->flush();
        $this->addFlash('success', 'Sócio removido com sucesso!');
        return $this->redirectToRoute('socio_index', ['empresaId' => $empresaId]);
    }
}

