<?php

namespace Drupal\contact_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\Markup;

class ShowContactController extends ControllerBase {
	
    public function show($cid) {
		return contact_book_show_contact($cid);
	}
}
