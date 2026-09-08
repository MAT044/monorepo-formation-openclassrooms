<?php

namespace TomTroc\Controller;

use DateTimeImmutable;
use TomTroc\Core\Framework\AbstractController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Model\Entity\Message;
use TomTroc\Model\Repository\MessageRepository;
use TomTroc\Model\Repository\UserRepository;
use TomTroc\View\Message\MessagerView;

class MessageController extends AbstractController
{
    public function __construct(
        private readonly MessageRepository $messageRepository,
        private readonly UserRepository $userRepository
    ) {
    }

    public function messager(Request $request)
    {
        $this->checkIfUserIsConnected();
        
        $targetId = $request->get('id', null);

        $currentUser = $this->userRepository->find($_SESSION['logged_user_id']);

        $targetUser = null;
        if($targetId) {
            $targetUser = $this->userRepository->find($targetId);
        }
        

        $isSend = ($request->method === Method::POST);

        $errors = [];

        if ($isSend) {
            $body = trim($request->get('body', null));

            if(!$targetUser) {
                $errors[] = 'Vous devez avoir un destinataire';
            }

            if (strlen($body) === 0) {
                $errors[] = 'Un message ne doit pas être vide';
            }

            if (strlen($body) > 255) {
                $errors[] = 'Un message ne peut pas dépasser 255 charactères';
            }

            if (count($errors) === 0) {
                $message = new Message($currentUser->id, $targetUser->id, $body, new DateTimeImmutable('now'));

                $this->messageRepository->create($message);
                $this->redirect('/conversations/' . $targetUser->id);
            }
        }

        $conversations = $this->messageRepository->findConversationsForUser($_SESSION['logged_user_id']);

        if($targetUser) {
            $messages = $this->messageRepository->findConversation($currentUser->id, $targetUser->id);

            $this->messageRepository->markConversationAsSeen($currentUser->id, $targetUser->id);
        }
        

        return $this->view(MessagerView::class, ['currentUser' => $currentUser, 'targetUser' => $targetUser, 'messages' => $messages, 'errors' => $errors, 'conversations' => $conversations]);
    }
}