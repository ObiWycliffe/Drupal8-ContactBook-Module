<?php

namespace Drupal\contact_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\Markup;

class ContactBookController extends ControllerBase {
  
      public function view() {
        return contact_book_create_table();
    }
}
