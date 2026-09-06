<?php

namespace TomTroc\View\Book;

use TomTroc\View\Layout;

class BookInfoView extends Layout {
    public function __construct() 
    {
        parent::__construct(title: 'Voir livre', contentTemplate: 'book/info');
    }
}