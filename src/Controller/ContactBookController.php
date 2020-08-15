<?php

namespace Drupal\contact_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;

class ContactBookController extends ControllerBase {
      public function view() {
        // Table haeders row
        $header = [
          'id' => t('Contact'),
          'name' => t('Name'),
          'email' => t('Email'),
          'phone' => t('Phone'),
          'address' => t('Address'),
          'country' => t('Country'),
          'manage' => t('Manage'),
          'remove' => t('Remove'),
        ];


        // checking contacts from table
        $db_query = \Drupal::database()->select('contact_book', 'contacts');
        $db_query->fields('contacts', ['id','name','email','phone','address','country']);
        $db_results = $db_query->execute()->fetchAll();
        $rows=array();
        foreach($db_results as $contact){
            $edit_contact   = Url::fromUserInput('/set/contacts?num='.$contact->id);
            $delete_contact = Url::fromUserInput('/delete/contact'.$contact->id);
            $p_contact = Url::fromUserInput('/view/contact'.$contact->id);

            //print the contact from table
            $rows[] = array(
                'id' =>$contact->id,
                'name' =>  \Drupal::l($contact->name, $p_contact),
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'country' => $contact->country,
  
                 \Drupal::l('Edit', $edit_contact),
                 \Drupal::l('Delete', $delete_contact),
              );
          }
        // $rows = [
        // // [Markup::create('<strong>test 1</strong>'),'test'],
        // // ['1', test', 'test@test.com', 'test12345', 'test-bcd', 'Kenya'],
        // // ['2', test', 'test@test.com', 'test12345', 'test-bcd', 'Kenya'],
        // ];

        $build['table'] = [
          '#type' => 'table',
          '#header' => $header,
          '#rows' => $rows,
          '#empty' => t('No contacts have been found.'),
        ];
        return [
          '#type' => '#markup',
          '#markup' => render($build)
        ];
    }
}
