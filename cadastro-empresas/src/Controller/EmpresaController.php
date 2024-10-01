<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Entity\Socio;
use App\Form\EmpresaForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpresaController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/empresa', name: 'empresa_index')]
    public function index(): Response
    {
        $empresas = $this->entityManager->getRepository(Empresa::class)->findAll();

        return $this->render('empresa/index.html.twig', [
            'empresas' => $empresas,
        ]);
    }

    #[Route('/empresa/new', name: 'empresa_new')]
    public function new(Request $request): Response
    {
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaForm::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($empresa);
            $this->entityManager->flush();
            $this->addFlash('success', 'Empresa criada com sucesso!');
            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('empresa/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/empresa/{id}', name: 'empresa_show')]
    public function show(Empresa $empresa): Response
    {
        return $this->render('empresa/show.html.twig', [
            'empresa' => $empresa,
        ]);
    }

    #[Route('/empresa/edit/{id}', name: 'empresa_edit')]
    public function edit(Request $request, Empresa $empresa): Response
    {
        $form = $this->createForm(EmpresaForm::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Empresa editada com sucesso!');
            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('empresa/edit.html.twig', [
            'form' => $form->createView(),
            'empresa' => $empresa,
        ]);
    }

    #[Route('/empresa/delete/{id}', name: 'empresa_delete')]
    public function delete(Empresa $empresa): Response
    {
        $socios = $this->entityManager->getRepository(Socio::class)->findBy(['empresa' => $empresa]);

        /**
         * Quando a empresa tiver socios vinculados, não é possivel excluir ela
         */
        if (count($socios) > 0) {
            $this->addFlash('error', 'Não é possível excluir a empresa porque ela possui sócios vinculados. Desvincule todos os sócios antes de excluir.');
            return $this->redirectToRoute('empresa_index');
        }

        $this->entityManager->remove($empresa);
        $this->entityManager->flush();

        $this->addFlash('success', 'Empresa excluída com sucesso!');
        return $this->redirectToRoute('empresa_index');
    }
}

