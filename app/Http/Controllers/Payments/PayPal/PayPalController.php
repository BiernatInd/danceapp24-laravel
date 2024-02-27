<?php

namespace App\Http\Controllers\Payments\PayPal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_SECRET')
            )
        );

        $this->apiContext->setConfig(
            array(
                'mode' => 'live', 
            )
        );
    }

    public function payPalSchoolPayment(Request $request)
    {
        // Walidacja danych wejściowych
        $request->validate([
            'totalPrice' => 'required|numeric',
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setTotal($request->totalPrice);
        $amount->setCurrency("USD");

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('https://danceconnect24.com/success-school-payment'))
                     ->setCancelUrl(url('https://danceconnect24.com/cancel-school-payment'));

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);

            return response()->json(['approvalUrl' => $payment->getApprovalLink()]);
        } catch (PayPalConnectionException $ex) {
            \Log::error("PayPal Payment Creation Error: " . $ex->getData());
            return response()->json(['error' => 'An error occurred during the payment process.'], 500);
        } catch (\Exception $ex) {
            \Log::error("General Error: " . $ex->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function executeSchoolPayment(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            if ($result->getState() == 'approved') {
                return response()->json(['success' => true, 'message' => 'Payment successful']);
            } else {
                return response()->json(['success' => false, 'message' => 'Payment not successful']);
            }
        } catch (\Exception $ex) {
            \Log::error("Payment Execution Error: " . $ex->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during the payment execution.'], 500);
        }
    }

    public function payPalClientPayment(Request $request)
    {

        \Log::info('Received payment data:', $request->all());
        
        $request->validate([
            'price' => 'required|numeric',
        ]);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setTotal($request->price);
        $amount->setCurrency("USD");

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('https://danceconnect24.com/thanks-for-order'))
                     ->setCancelUrl(url('https://danceconnect24.com/cancel-school-payment'));

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);

            return response()->json(['approvalUrl' => $payment->getApprovalLink()]);
        } catch (PayPalConnectionException $ex) {
            \Log::error("PayPal Payment Creation Error: " . $ex->getData());
            return response()->json(['error' => 'An error occurred during the payment process.'], 500);
        } catch (\Exception $ex) {
            \Log::error("General Error: " . $ex->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function executeClientPayment(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            if ($result->getState() == 'approved') {
                return response()->json(['success' => true, 'message' => 'Payment successful']);
            } else {
                return response()->json(['success' => false, 'message' => 'Payment not successful']);
            }
        } catch (\Exception $ex) {
            \Log::error("Payment Execution Error: " . $ex->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred during the payment execution.'], 500);
        }
    }
}