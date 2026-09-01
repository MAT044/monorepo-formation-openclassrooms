<?php

namespace TomTroc\View\User;

use TomTroc\View\Layout;

class LoginView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Connexion', contentTemplate: 'user/login');
    }
}