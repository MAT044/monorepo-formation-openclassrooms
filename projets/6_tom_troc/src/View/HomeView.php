<?php

namespace TomTroc\View;

use TomTroc\View\Layout;

class HomeView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Accueil', contentTemplate: 'home/index');
    }
}