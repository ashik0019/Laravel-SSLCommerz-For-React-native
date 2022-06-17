<?php

namespace App\Http\Controllers\API;

use App\Order;
use App\OrderCommission;
use App\VendorDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Redirect;
//use Session;
use Illuminate\Support\Facades\Session;
use Lang;

//use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;

session_start();

class PublicSslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate  payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "order_id","ssl_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $request->total_amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        #Start to save these value  in session to pick in success page.
        $_SESSION['payment_values']['tran_id'] = $post_data['tran_id'];
        #End to save these value  in session to pick in success page.
//dd($_SESSION['payment_values']['tran_id']);
//        $server_name=$request->root()."/";
        $server_name = url('/');
        $post_data['success_url'] = $server_name . "/api/success";
        $post_data['fail_url'] = $server_name . "/api/fail";
        $post_data['cancel_url'] = $server_name . "/api/cancel";

        #Before  going to initiate the payment order status need to update as Pending.
        $sslc = new SSLCommerz();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->initiate($post_data, true);
///        dd($payment_options);

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        $sslc = new SSLCommerz();
        return redirect('api/ssl/redirect/success');
    }

    public function fail(Request $request)
    {

        $tran_id = $request->tran_id;
        return redirect('api/ssl/redirect/fail');

    }

    public function cancel(Request $request)
    {
        return redirect('api/ssl/redirect/cancel');

    }

    public function ipn(Request $request)
    {
        return redirect('api/ssl/redirect/success');

    }

    public function status($status)
    {
        return view("status", compact('status'));
    }

    public function statusWeb($status)
    {
        return view("status", compact('status'));
    }

}

