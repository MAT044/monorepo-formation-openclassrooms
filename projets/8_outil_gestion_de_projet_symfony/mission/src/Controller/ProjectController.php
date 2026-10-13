<?php

namespace App\Controller;

use App\Dto\WriteProjectDto;
use App\Entity\Project;
use App\Entity\ProjectMember;
use App\Form\ProjectType;
use App\Repository\ProjectMemberRepository;
use App\Repository\ProjectRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectMemberRepository $projectMemberRepository
    ){}

    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findActive(),
        ]);
    }

    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dto = new WriteProjectDto();
        $form = $this->createForm(ProjectType::class, $dto);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project = new Project();
            $project
                ->setTitle($dto->title);
            
            foreach($dto->members as $member) {
                $projectMember = new ProjectMember();
                $projectMember->setMember($member)->setProject($project);
                $entityManager->persist($projectMember);
            }

            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/new.html.twig', [
            'project' => $dto,
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $projectMembers = $this->projectMemberRepository->findBy(['project' => $project]);
        $members = array_map(fn(ProjectMember $pm) => $pm->getMember(), $projectMembers);

        $dto = new WriteProjectDto();
        $dto->title = $project->getTitle();
        $dto->members = $members;


        $form = $this->createForm(ProjectType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project
                ->setTitle($dto->title);

            foreach($projectMembers as $projectMember) {
                if(!in_array($projectMember->getMember(), $dto->members)) {
                    $entityManager->remove($projectMember);
                }
            }

            foreach($dto->members as $member) {
                if(!in_array($member, $members)){
                    $projectMember = new ProjectMember();
                    $projectMember->setMember($member)->setProject($project);
                    $entityManager->persist($projectMember);
                }
            }
                
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}/delete', name: 'app_project_delete', methods: ['GET'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->query->get('_token'))) {
            $project->setArchivedAt(new DateTimeImmutable('now'));
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }
}
