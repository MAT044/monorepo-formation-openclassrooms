<?php

namespace TomTroc\Controller;

use DateTimeImmutable;
use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Http\Response;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Repository\UserRepository;
use TomTroc\View\User\AccountView;
use TomTroc\View\User\LoginView;
use TomTroc\View\User\RegisterView;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function login(Request $request): Response
    {
        $isSend = ($request->method === Method::POST);

        $errors = [];

        if($isSend) {
            $email = $request->get('email', null);
            $password = $request->get('password', null);

            $user = $this->userRepository->findByEmail($email);

            if($user === null || !password_verify($password, $user->passwordHash)) {
                $errors[] = "Utilisateur inconnu ou mot de passe invalide";
            }
            
            if(count($errors) === 0) {
                $_SESSION['logged_user_id'] = $user->id;
                return $this->redirect('/');
            }
        }
        return $this->view(LoginView::class, ['errors' => $errors]);
    }

    public function register(Request $request): Response
    {
        
        $isSend = ($request->method === Method::POST);

        $errors = [];

        if($isSend) {
            $username = $request->get('pseudo', null);
            $email = $request->get('email', null);
            $password = $request->get('password', null);

            if(strlen($username) < 4) {
                $errors[] = "Un pseudo doit faire au moins 4 charactères";
            }

            if(strlen($username) > 12) {
                $errors[] = "Un pseudo doit faire moins de 12 charactères";
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Une adresse email valide doit être renseignée";
            }

            if(strlen($password) < 4) {
                $errors[] = "Un mot de passe doit faire au moins 4 charactères";
            }

            if(strlen($password) > 20) {
                $errors[] = "Un mot de passe doit faire moins de 20 charactères";
            }
            
            if(count($errors) === 0) {
                $user = new User(
                    null,
                    $email,
                    password_hash($password, PASSWORD_DEFAULT),
                    $username,
                    new DateTimeImmutable('now')
                );
                
                $this->userRepository->create($user);
                return $this->redirect('/connexion');
            }
        }
        return $this->view(RegisterView::class, ['errors' => $errors]);
    }
}