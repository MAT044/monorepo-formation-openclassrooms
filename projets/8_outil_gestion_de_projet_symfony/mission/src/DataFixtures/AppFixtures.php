<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\ProjectMember;
use App\Entity\Task;
use App\Enum\TaskStatus;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private array $EMPLOYEE_DATA = [
            [
                "firstname" => "Natalie",
                "lastname" => "Dillon",
                "email" => "natalie.dillon@driblet.com",
                "status" => "CDI",
                "entryAt" => new DateTimeImmutable("2019/6/14")
            ],
            [
                "firstname" => "Demi",
                "lastname" => "Backer",
                "email" => "demi.backer@driblet.com",
                "status" => "CDD",
                "entryAt" => new DateTimeImmutable("2026/7/15")
            ],
            [
                "firstname" => "Marie",
                "lastname" => "Dupont",
                "email" => "marie.dupont@driblet.com",
                "status" => "Freelance",
                "entryAt" => new DateTimeImmutable("2020/1/20")
            ],
            [
                "firstname" => "Vincent",
                "lastname" => "Dorian",
                "email" => "vincent.dorian@bobet-materiel.com",
                "status" => "Etudiant",
                "entryAt" => new DateTimeImmutable("2026/10/7")
            ],
        ],

        private array $PROJECT_DATA = [
            [
                "title" => "Tasklinker",
                "archivedAt" => null
            ],
            [
                "title" => "Site Marchand",
                "archivedAt" => new DateTimeImmutable('now')
            ],
            [
                "title" => "Site vitrine Les Soeurs Marchand",
                "archivedAt" => null
            ]
        ],

        private array $PROJECT_MEMBERS_DATA = [
            [
                "project" => 0,
                "employee" => 0
            ],
            [
                "project" => 0,
                "employee" => 1
            ],
            [
                "project" => 1,
                "employee" => 0
            ],
            [
                "project" => 1,
                "employee" => 1
            ],
            [
                "project" => 1,
                "employee" => 2
            ],
            [
                "project" => 2,
                "employee" => 1
            ],
            [
                "project" => 2,
                "employee" => 2
            ],
            [
                "project" => 0,
                "employee" => 3
            ],
        ],

        private array $TASKS_DATA = [
            [
                "title" => "Initialiser le projet avec git",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::Done,
                "member" => 3
            ],
            [
                "title" => "Créez votre base de données",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::Done,
                "member" => 3
            ],
            [
                "title" => "Créez la page d'accueil",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::Doing,
                "member" => 3
            ],
            [
                "title" => "Créez la page d'un projet",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::ToDo,
                "member" => 3
            ],
            [
                "title" => "Créez la gestion des employés",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::ToDo,
                "member" => 3
            ],
            [
                "title" => "Préparez votre auto-évaluation",
                "description" => null,
                "date" => new DateTimeImmutable('now'),
                "status" => TaskStatus::ToDo,
                "member" => 3
            ],
        ],
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $employees = [];
        foreach ($this->EMPLOYEE_DATA as $employeeData) {
            $new = new Employee();
            $new
                ->setFirstname($employeeData['firstname'])
                ->setLastname($employeeData['lastname'])
                ->setEmail($employeeData['email'])
                ->setStatus($employeeData['status'])
                ->setEntryAt($employeeData['entryAt']);
            $manager->persist($new);
            $employees[] = $new;
        }

        $projects = [];
        foreach ($this->PROJECT_DATA as $projectData) {
            $new = new Project();
            $new
                ->setTitle($projectData['title'])
                ->setArchivedAt($projectData['archivedAt']);
            $manager->persist($new);
            $projects[] = $new;
        }

        foreach ($this->PROJECT_MEMBERS_DATA as $data) {
            $new = new ProjectMember();
            $new
                ->setProject($projects[$data['project']])
                ->setMember($employees[$data['employee']]);
            $manager->persist($new);
        }

        foreach ($this->TASKS_DATA as $data) {
            $new = new Task();
            $new
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setDate($data['date'])
                ->setStatus($data['status'])
                ->setMember($employees[$data['member']]);
            $manager->persist($new);
        }

        $manager->flush();
    }
}
