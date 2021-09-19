<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Paynow\Payments\Paynow;

//page excution time set to 200 seconds
set_time_limit(200);

class ProcessPaymentController extends Controller
{

    public function check_out(Request $request)
    {

        if ($request->ajax()) {

            $mobileNumber = strtolower($request->get('mobileNumber'));
            $amount = $request->get('amount');
             return $this->process_payment($mobileNumber, $amount);            
        }
    }

    public function process_payment($mobileNumber, $amount)
    {
        //customer mobile number
        $mobile_number = '0771111111'; //$mobile_number

        //wallet type
        $wallet_name = 'ecocash';

        // Detect platform and send payment
        if (strpos($mobile_number, '071') === 0) {
            $wallet_name = "onemoney";
        }

        if (strpos($mobile_number, '073') === 0) {
            $wallet_name = "telecash";
        }

        //invoice referance generation
        $invoice_ref = md5((rand(1000000000000000, 99999999999999999) . date('d-m-Y H:i:s:')) . microtime(true));

        //customer email address
        $customer_email = 'user@example.com';

        //express check out value
        $invoice_amount = '12.00'; //$amount;

        //payment data array
        $payment_data = array();

        $paynow = new \Paynow\Payments\Paynow(
            env('PAYNOW_ID'),
            env('PAYNOW_INTEGRATION_KEY'),
            env('PAYNOW_UPDATE_URL'),
            env('PAYNOW_RETURN_URL'),
        );

        //$transactionDescription = 'Cart check out description';
        $payment = $paynow->createPayment($invoice_ref, $customer_email);
        $payment->add('ChecK out', $invoice_amount);

        // Save the response from paynow in a variable
        $response = $paynow->sendMobile($payment, $mobile_number, $wallet_name);

        if ($response->success()) {
            // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
            $pollUrl = $response->pollUrl();

            //120 seconds, timing transaction waiting for paid status
            $payment_start_time = microtime(true);

            do {
                sleep(5);
                flush();
                $status = $paynow->pollTransaction($pollUrl);

                // break loop when transaction has paid status
                if ($status->paid()) {
                    break;
                }

            } while (!$status->paid() && (microtime(true) - $payment_start_time) < 140);

            //prepare transaction for response Ajax respose data
            $paynow_data = $status->data();

            array_push($payment_data, [
                'wallet' => $wallet_name,
                'paynow_ref' => $paynow_data['paynowreference'],
                'invoice_ref' => $invoice_ref,
                'customer_email' => $customer_email,
                'invoice_amount' => $invoice_amount,
                'poll_url' => $pollUrl,
                'hash' => $paynow_data['hash'],
                'status' => $paynow_data['status'],

            ]);

            return array('payment_status' => $status->status(), 'payment_data' => $payment_data);

        } else {
            return array('payment_status' => 'error');
        }

    }

}
