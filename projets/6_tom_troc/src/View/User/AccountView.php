<?php

namespace TomTroc\View\User;

use TomTroc\View\Layout;

class AccountView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Mon compte', contentTemplate: 'user/account');
    }
}