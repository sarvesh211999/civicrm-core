<?php

/**
 *  Test CRM_Event_Form_Registration functions.
 *
 * @package   CiviCRM
 * @group headless
 */
class CRM_Event_Form_Registration_ConfirmTest extends CiviUnitTestCase {

  use CRMTraits_Profile_ProfileTrait;

  public function setUp() {
    $this->useTransaction(TRUE);
    parent::setUp();
  }

  /**
   * Test for Multiple participant.
   *
   * @throws \CRM_Core_Exception
   */
  public function testMultipleParticipant() {
    $mut = new CiviMailUtils($this);
    $params = ['is_monetary' => 1, 'financial_type_id' => 1];
    $event = $this->eventCreate($params);
    CRM_Event_Form_Registration_Confirm::testSubmit([
      'id' => $event['id'],
      'contributeMode' => 'direct',
      'registerByID' => $this->createLoggedInUser(),
      'totalAmount' => 440,
      'event' => reset($event['values']),
      'params' => [
        [
          'qfKey' => 'e6eb2903eae63d4c5c6cc70bfdda8741_2801',
          'entryURL' => "http://dmaster.local/civicrm/event/register?reset=1&amp;id={$event['id']}",
          'first_name' => 'Participant1',
          'last_name' => 'LastName',
          'email-Primary' => 'participant1@example.com',
          'additional_participants' => 2,
          'payment_processor_id' => 0,
          'bypass_payment' => '',
          'MAX_FILE_SIZE' => '33554432',
          'is_primary' => 1,
          'is_pay_later' => 1,
          'campaign_id' => NULL,
          'defaultRole' => 1,
          'participant_role_id' => '1',
          'currencyID' => 'USD',
          'amount_level' => 'Tiny-tots (ages 5-8) - 1',
          'amount' => '100.00',
          'tax_amount' => 10,
          'ip_address' => '127.0.0.1',
          'invoiceID' => '57adc34957a29171948e8643ce906332',
          'trxn_id' => '123456789',
          'button' => '_qf_Register_upload',
        ],
        [
          'qfKey' => 'e6eb2903eae63d4c5c6cc70bfdda8741_2801',
          'entryURL' => "http://dmaster.local/civicrm/event/register?reset=1&amp;id={$event['id']}",
          'first_name' => 'Participant2',
          'last_name' => 'LastName',
          'email-Primary' => 'participant2@example.com',
          'scriptFee' => '',
          'scriptArray' => '',
          'campaign_id' => NULL,
          'is_pay_later' => 1,
          'participant_role_id' => '1',
          'currencyID' => 'USD',
          'amount_level' => 'Tiny-tots (ages 9-18) - 1',
          'amount' => '200.00',
          'tax_amount' => 20,
        ],
        [
          'qfKey' => 'e6eb2903eae63d4c5c6cc70bfdda8741_2801',
          'entryURL' => "http://dmaster.local/civicrm/event/register?reset=1&amp;id={$event['id']}",
          'first_name' => 'Participant3',
          'last_name' => 'LastName',
          'email-Primary' => 'participant3@example.com',
          'scriptFee' => '',
          'scriptArray' => '',
          'campaign_id' => NULL,
          'is_pay_later' => 1,
          'participant_role_id' => '1',
          'currencyID' => 'USD',
          'amount_level' => 'Tiny-tots (ages 5-8) - 1',
          'amount' => '100.00',
          'tax_amount' => 10,
        ],
      ],
    ]);
    $participants = $this->callAPISuccess('Participant', 'get', [])['values'];
    $participantspayment = $this->callAPISuccess('ParticipantPayment', 'get', [])['values'];
    
    $ids_participant = array_column($participants, 'participant_id');
    
    $ids_payment_participant = array_column($participantspayment, 'participant_id');
    if ($ids_participant == $ids_payment_participant)
      $this->assertTrue(true);
    else
      $this->assertFalse(true);

  }



}
