<?php

namespace Drupal\contact_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;

class ShowContactController extends ControllerBase {
	
    public function show($cid) {
		// checking contacts from table
		$db_query = \Drupal::database()->select('contact_book', 'contact')->condition('id', $cid);
		$db_query->fields('contact', ['id','name','email','phone','address','country']);
		$db_result = $db_query->execute()->fetchAll();
		// dd($db_result);
		$row=array();
  
		foreach($db_result as $contact){
		  // dd($contact->name);
			$back = Url::fromUserInput('/view/contacts');
			$edit_contact   = Url::fromUserInput('/set/contact?cid='.$contact->id);
			$delete_contact = Url::fromUserInput('/delete/contact/'.$contact->id);
  
			return array(
			  '#title' => 'PhoneBook Details:',
			  '#markup' => '<h2>'.'Contact Name: <u>'.$contact->name.'</u></h2>'.
						  '<small>'.'<b>Email:</b> '.$contact->email.'</small>'.
						  '<small>'.'<b> Mobile:</b> '.$contact->phone.'</small>'.'</br>'.
						  '<strong>'.'Country: '.'</strong>'.'<i>'.$contact->country.'</i>'.'</br>'.
						  '<b>'.'Address: '.'</b>'.'</i>'.$contact->address.'</i>'.'</br>'.'</br>'.
						  '<h6>'.'<b> Manage Contact: </b> '
								.\Drupal::l('Edit', $edit_contact).' '.'<b>|</b>'.' '.\Drupal::l('Delete', $delete_contact).
						  '</h6>'.'</br>'.
						  '<p>'.'<b> Go Back:</b> '.\Drupal::l('Return to Contacts Table', $back).'</p>'
			);
		  }
  
	}
}
