<?php

namespace Drupal\contact_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AddContactForm extends FormBase{
    
    public function getFormId(){
        return 'contact_book_form';
    }

    
    public function buildForm(array $form,FormStateInterface $form_state){

        $db_con = Database::getConnection();
        $record = array();
        if (isset($_GET['cid'])) {
            $query = $db_con->select('contact_book', 'contacts')
                ->condition('id', $_GET['cid'])
                ->fields('contacts');
            $record = $query->execute()->fetchAssoc();
        }

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Name:'),
            '#required' => true,
            '#default_value' => (isset($record['name']) && $_GET['cid']) ? $record['name']:'',
        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email:'),
            '#required' => true,
            '#unique'=> true,
            '#default_value' => (isset($record['email']) && $_GET['cid']) ? $record['email']:'',
        );
        $form['phone'] = array(
            '#type' => 'tel',
            '#title' => $this->t('Phone:'),
            '#default_value' => (isset($record['phone']) && $_GET['cid']) ? $record['phone']:'',
        );
        $form['address'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Address:'),
            '#default_value' => (isset($record['address']) && $_GET['cid']) ? $record['address']:'',
        );
        $form['country'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Country:'),
            '#default_value' => (isset($record['country']) && $_GET['cid']) ? $record['country']:'',
        );
        
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Save'),
        '#button_type' => 'primary',
        );
        return $form;
    }
    
    public function validateForm(array &$form, FormStateInterface $form_state) {
        
      if (strlen($form_state->getValue('email')) < 10) {
        $form_state->setErrorByName('email', $this->t('The email address you\'ve set is too short.'));
    }

    }
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // foreach ($form_state->getValues() as $key => $value) {
        //     drupal_set_message($key . ': ' . $value);
        //   }

        // drupal_set_message($this->t('New contact has been added succesfully'));

        $db_row=$form_state->getValues();
        $name=$db_row['name'];
        $email=$db_row['email'];
        $phone=$db_row['phone'];
        $address=$db_row['address'];
        $country=$db_row['country'];

        if (isset($_GET['cid'])) {
            $db_row  = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'country' => $country,
            );
            $query = \Drupal::database();
            $query->update('contact_book')
                ->fields($db_row)
                ->condition('id', $_GET['cid'])
                ->execute();
            drupal_set_message("Contact updated succesfully");
            $form_state->setRedirect('contact_book.view');
        }
         else
         {
             $db_row  = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'country' => $country,
            );
             $query = \Drupal::database();
             $query ->insert('contact_book')
                 ->fields($db_row)
                 ->execute();
             drupal_set_message("New contact added successfully");
             $response = new RedirectResponse("/view/contacts");
             $response->send();
         }
    }
}