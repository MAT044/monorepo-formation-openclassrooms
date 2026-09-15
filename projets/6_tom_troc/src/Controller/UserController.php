<?php

namespace TomTroc\Controller;

use DateTimeImmutable;
use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Http\Response;
use TomTroc\Model\Entity\User;
use TomTroc\Model\Repository\BookRepository;
use TomTroc\Model\Repository\UserRepository;
use TomTroc\View\User\AccountView;
use TomTroc\View\User\LoginView;
use TomTroc\View\User\RegisterView;
use TomTroc\View\User\UserInfoView;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BookRepository $bookRepository
    ) {
    }

    public function account(Request $request): Response
    {
        $this->checkIfUserIsConnected();
        $user = $this->userRepository->find($_SESSION['logged_user_id']);

        $isSend = ($request->method === Method::POST);

        $errors = [];

        if($isSend) {
            $username = trim($request->get('username', null));
            $email = trim($request->get('email', null));
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

            if($email !== $user->email && $this->userRepository->findByEmail($email)) {
                $errors[] = "Adresse email déjà utilisée";
            }

            if(strlen($password) < 4) {
                $errors[] = "Un mot de passe doit faire au moins 4 charactères";
            }

            if(strlen($password) > 20) {
                $errors[] = "Un mot de passe doit faire moins de 20 charactères";
            }
            
            if(count($errors) === 0) {
                $user = $user->update(
                    $email,
                    password_hash($password, PASSWORD_DEFAULT),
                    $username
                );
                
                $this->userRepository->update($user);
                return $this->redirect('/mon-compte');
            }
        }

        $books = $this->bookRepository->findByUser($user->id);

        return $this->view(AccountView::class, ['user' => $user, 'books' => $books, 'errors' => $errors]);
    }

    public function avatar(Request $request): Response
    {
        $this->checkIfUserIsConnected();
        $user = $this->userRepository->find($_SESSION['logged_user_id']);

        $file = $request->file('avatar_file');

        if (!is_array($file) || !isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return $this->redirect('/mon-compte?error=avatar_invalide');
        }

        $mime = mime_content_type($file['tmp_name']);
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

        if (!in_array($mime, $allowedMimeTypes, true)) {
            return $this->redirect('/mon-compte?error=avatar_format');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            return $this->redirect('/mon-compte?error=avatar_taille');
        }

        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        $extension = $extensionMap[$mime];
        $safeUsername = preg_replace('/[^A-Za-z0-9_-]+/', '_', $user->username);
        $safeUsername = trim($safeUsername, '_');

        if ($safeUsername === '') {
            $safeUsername = 'user';
        }

        $uploadDirectory = dirname(__DIR__, 2) . '/public/upload/avatar';

        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0777, true) && !is_dir($uploadDirectory)) {
            return $this->redirect('/mon-compte?error=avatar_upload');
        }

        $filename = sprintf('%d_%s_%s.%s', $user->id, $safeUsername, uniqid('', true), $extension);
        $destination = $uploadDirectory . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return $this->redirect('/mon-compte?error=avatar_upload');
        }

        $this->userRepository->update($user->updateAvatar('/upload/avatar/' . $filename));

        return $this->redirect('/mon-compte');
    }

    public function info(Request $request): Response
    {
        $userId = $request->get('id', null);
        $user = $this->userRepository->find((int) $userId);

        if ($user === null) {
            throw new \Exception('Utilisateur introuvable');
        }

        $books = $this->bookRepository->findByUser($user->id);

        return $this->view(UserInfoView::class, ['user' => $user, 'books' => $books]);
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
            $username = trim($request->get('username', null));
            $email = trim($request->get('email', null));
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

            if($this->userRepository->findByEmail($email)) {
                $errors[] = "Adresse email déjà utilisée";
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
                    new DateTimeImmutable('now'),
                    null
                );
                
                $this->userRepository->create($user);
                return $this->redirect('/connexion');
            }
        }
        return $this->view(RegisterView::class, ['errors' => $errors]);
    }
}