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

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('ASLrgrBnJAwFP5YsdlLFQQVRolMVrrkmFpol0vc4ktyc9Al5R5BhbrO0wLPnmzfX0RqNPYuLsvmxVfPX'),
                env('EFo13dyt3UvAOCOIGDpZTnhUZaJk7TJ68wDjPIJ89p6BbLU_XYa0kcPMy-EufH9QpLhGAeCFz7L497mZ')
            )
        );

        $this->apiContext->setConfig(
            array(
                'mode' => 'sandbox', 
            )
        );
    }

    public function payPalPayment(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setTotal($request->totalPrice);
        $amount->setCurrency("AED");

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/payment/success'))
                     ->setCancelUrl(url('/payment/cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);

            return response()->json(['approvalUrl' => $payment->getApprovalLink()]);
        } catch (Exception $ex) {
            // Obsługa błędów
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
