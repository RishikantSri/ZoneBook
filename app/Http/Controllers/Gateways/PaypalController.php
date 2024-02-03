<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    //
    public function payment(Request $request)
    {

        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);

        // dd($response);

        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $link) {

                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        // dd($request->all(), $response);

        //     array:2 [▼ // app\Http\Controllers\Gateways\PaypalController.php:65
        //      "token" => "1MU23627YE164650F"
        //      "PayerID" => "X99YXCXCYL8A6"

        //   array:6 [▼ // app\Http\Controllers\Gateways\PaypalController.php:65
        //   "id" => "1MU23627YE164650F"
        //   "status" => "COMPLETED"
        //   "payment_source" => array:1 [▼
        //     "paypal" => array:5 [▼
        //       "email_address" => "sb-wdddk7250408@personal.example.com"
        //       "account_id" => "X99YXCXCYL8A6"
        //       "account_status" => "VERIFIED"
        //       "name" => array:2 [▼
        //         "given_name" => "John"
        //         "surname" => "Doe"
        //       ]
        //       "address" => array:1 [▼
        //         "country_code" => "US"
        //       ]
        //     ]
        //   ]
        //   "purchase_units" => array:1 [▼
        //     0 => array:3 [▼
        //       "reference_id" => "default"
        //       "shipping" => array:2 [▼
        //         "name" => array:1 [▼
        //           "full_name" => "John Doe"
        //         ]
        //         "address" => array:5 [▼
        //           "address_line_1" => "1 Main St"
        //           "admin_area_2" => "San Jose"
        //           "admin_area_1" => "CA"
        //           "postal_code" => "95131"
        //           "country_code" => "US"
        //         ]
        //       ]
        //       "payments" => array:1 [▼
        //         "captures" => array:1 [▼
        //           0 => array:9 [▼
        //             "id" => "9JN16455SG900223B"
        //             "status" => "COMPLETED"
        //             "amount" => array:2 [▼
        //               "currency_code" => "USD"
        //               "value" => "40.00"
        //             ]
        //             "final_capture" => true
        //             "seller_protection" => array:2 [▼
        //               "status" => "ELIGIBLE"
        //               "dispute_categories" => array:2 [▼
        //                 0 => "ITEM_NOT_RECEIVED"
        //                 1 => "UNAUTHORIZED_TRANSACTION"
        //               ]
        //             ]
        //             "seller_receivable_breakdown" => array:3 [▼
        //               "gross_amount" => array:2 [▼
        //                 "currency_code" => "USD"
        //                 "value" => "40.00"
        //               ]
        //               "paypal_fee" => array:2 [▼
        //                 "currency_code" => "USD"
        //                 "value" => "2.19"
        //               ]
        //               "net_amount" => array:2 [▼
        //                 "currency_code" => "USD"
        //                 "value" => "37.81"
        //               ]
        //             ]
        //             "links" => array:3 [▶]
        //             "create_time" => "2024-02-02T07:20:36Z"
        //             "update_time" => "2024-02-02T07:20:36Z"
        //           ]
        //         ]
        //       ]
        //     ]
        //   ]
        //   "payer" => array:4 [▼
        //     "name" => array:2 [▼
        //       "given_name" => "John"
        //       "surname" => "Doe"
        //     ]
        //     "email_address" => "sb-wdddk7250408@personal.example.com"
        //     "payer_id" => "X99YXCXCYL8A6"
        //     "address" => array:1 [▼
        //       "country_code" => "US"
        //     ]
        //   ]
        //   "links" => array:1 [▼
        //     0 => array:3 [▼
        //       "href" => "https://api.sandbox.paypal.com/v2/checkout/orders/1MU23627YE164650F"
        //       "rel" => "self"
        //       "method" => "GET"
        //     ]
        //   ]
        // ]



        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // update database
            return 'Paid Successfully!';
        }

        // update database
        return redirect()->route('paypal.cancel');
    }

    public function cancel()
    {
        return 'Paymnet faild';
    }
}
