<?php

namespace TomTroc\Controller;

use TomTroc\Core\Framework\AbstractController;
use TomTroc\Model\Repository\MessageRepository;

class LayoutController extends AbstractController {
    public function __construct(
        private readonly MessageRepository $messageRepository
    ) {
    }

    public function header() {
        $unreadNumber = 0;
        if($this->isConnected()){
            $unreadNumber = $this->messageRepository->countUnreadForUser($_SESSION['logged_user_id'] );
        }
        
        return [
            'isConnected' => $this->isConnected(),
            'unreadNumber' => $unreadNumber 
        ];
    }
}