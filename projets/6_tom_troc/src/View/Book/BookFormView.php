<?php

namespace TomTroc\View\Book;

use TomTroc\View\Layout;

class BookFormView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Créer livre', contentTemplate: 'book/form');
    }
}