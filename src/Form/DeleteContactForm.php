<?php
namespace Drupal\contact_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
// use Drupal\Core\Render\Element;
use Drupal\Core\Url;


class DeleteContactForm extends ConfirmFormBase {
  
  public function getFormId() {
    return 'delete_contact_form';
  }

  // Body Text
    public function getQuestion() {
        $cont_id = $this->id;
        // dd($cont_id);
        return t('Contact id: %contact_id selected for deletion', array('%contact_id' => $cont_id));
    }

    public function getDescription() {
        return t('Do you want to proceed with Actions? <br> <b>Actions Once Taken Cannot be Un-done!</b>');
    }

    public function getConfirmText() {
        return t('Delete Contact');
    }

    public function getCancelText() {
        return t('Cancel | Go Back');
    }
  // End Body Text

  
 public function getCancelUrl() {
    return new Url('contact_book.view');
  }

  
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
     // dd($cid);
     $this->id = $cid;
    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
       $query = \Drupal::database();
       $query->delete('contact_book')
                   ->condition('id',$this->id)
                   ->execute();
             drupal_set_message( t("Contact id: %contact_id succesfully deleted !", array('%contact_id' => $this->id)) );
       $form_state->setRedirect('contact_book.view');
  }
}