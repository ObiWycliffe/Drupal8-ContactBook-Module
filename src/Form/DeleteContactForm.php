<?php

namespace Drupal\contact_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class DeleteContactForm extends FormBase {
    
  public function getFormId() {
    return 'contact_book_form';
  }

  // Contact id / node identifier
  // public $cid;

public function buildForm(array $form,FormStateInterface $form_state){

    // ...
}

public function validateForm(array &$form, FormStateInterface $form_state) {

    // ...

}


public function submitForm(array &$form, FormStateInterface $form_state) {

    dd($_GET['cid']);
    if (isset($_GET['cid']) != NULL) {
        $query = \Drupal::database();
        $query->delete('contact_book')
            ->condition('id', $_GET['cid'])
            ->execute();
        drupal_set_message("Contact deleted succesfully");
        $form_state->setRedirect('contact_book.view');
    }
}
}