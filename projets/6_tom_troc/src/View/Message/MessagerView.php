<?php

namespace TomTroc\View\Message;

use TomTroc\View\Layout;

class MessagerView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Messagerie', contentTemplate: 'message/messager');
    }
}