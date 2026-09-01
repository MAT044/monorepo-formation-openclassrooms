<?php

namespace TomTroc\View\User;

use TomTroc\View\Layout;

class RegisterView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Inscription', contentTemplate: 'user/register');
    }
}