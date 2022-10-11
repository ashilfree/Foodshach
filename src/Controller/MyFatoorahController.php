<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Mailer;
use App\Classes\Transaction;
use App\Classes\WishList;
use App\Entity\Order;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MyFatoorahController extends AbstractController
{
//    //Test
    private $apiURL = 'https://apitest.myfatoorah.com';
    private $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

//    //Live
//    private $apiURL = 'https://api.myfatoorah.com';
//    private $apiKey = 'MFMNumJQBRZWKW8yo2DiLjioWjjnZDl_MZtDHFkuz9lcgwudSxeg0ewqqWyHywH6LZsXCiHJt3blj5F9M2S59jB11BkELxNEZsKC_wCqV9J3zJbGAOJc0JDYV_EHmZkkR2LFgTd9MXRsfkiLYfC84O-bpHUV2EltRNHlRtMKY0MaCKzJ6IReoMgK-X8OLKRf4GH4n9jCyMWwZ0DUtML9CrFwhDCS5hmawLnriiiddWcPXI06AJu3nrJLYNnt0vCyhcWuW62LTYvxf0V6N9JVTV-fnBs1Xzh0JFVaMXKcVQhZA6PzEeOiDj8albMszPccX0VW-mehEtLUKIHhj2qhsYWvTx1_GIz2oZR1JwqXPeCUJWCX5Kfi3hpNt9aXOSioGrDI0KWP9MC9qaDEEttfno3FFe_3YdSZTu_tH642h0W7WmC3-WZnzpue5L-RZFmksw9lQTmrL7TwaJfuwOkTJQbuDSZ2qs-ZT2xv3MVBlj7L7P7WQP9Q7pmXWZG7QXZUvW6-5oudLeCMokxmQzuYPF8ByExdFd5AHHSAaONgd2vrJhAXLqMOwKtLU0Km-9Q8ov8sJ2ZL0pMt77s4vQvPeeD6M3Z_QCwRZ88FLa7bATeGUTMzSHsWRryi95WecvrmQZHEop3mft_3ED64Ijx1XBWiyaLYS-skxOcuZz9kGDOLNILu9kx8ZIkw1ijwNY1MCisteg'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Transaction
     */
    private $transaction;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var SessionInterface
     */
    private $session;
    //Live
    //private $apiURL = 'https://api.myfatoorah.com';
    //private $apiKey = ''; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, Transaction $transaction, Mailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->transaction = $transaction;
        $this->mailer = $mailer;
        $this->session = $session;
    }

    /**
     * @Route("/{locale}/order/create-session/{id}", name="my.fatoorah.create.session", defaults={"locale"="en"})
     * @param $locale
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @param Transaction $transaction
     * @return Response
     */
    public function index($locale, $id, EntityManagerInterface $entityManager, Transaction $transaction): Response
    {
        /**
         * @var Order $order
         */
        $order = $entityManager->getRepository(Order::class)->find($id);
        if($order->getPaymentMethod()){
            if (!$order || !$transaction->check($order, 'proceed_checkout'))
                return new JsonResponse(["error" => 'order']);
            $this->transaction->applyWorkFlow($order, 'proceed_checkout');
            $YOUR_DOMAIN = 'https://foodshackkw.com';
//            $YOUR_DOMAIN = 'https://127.0.0.1:8000';
            //Fill POST fields array
            $ipPostFields = ['InvoiceAmount' => ($order->getTotalOrder()  / 100) , 'CurrencyIso' => 'KWD'];

            //Call endpoint
            $paymentMethods = $this->initiatePayment($this->apiURL, $this->apiKey, $ipPostFields);

            //You can save $paymentMethods information in database to be used later
            foreach ($paymentMethods as $pm) {
                if ($pm->PaymentMethodEn == $order->getPaymentMethod()) {
                    $paymentMethodId = $pm->PaymentMethodId;
                    break;
                }
            }

            /* ------------------------ Call ExecutePayment Endpoint ---------------------*/
            //Fill customer address array
            $customerAddress = array(
                'Block' => '', //optional
                'Street' => '', //optional
                'HouseBuildingNo' => '', //optional
                'Address' => $order->getShippingHouseNumber() .'-'.$order->getShippingStreetNumber(), //optional
                'AddressInstructions' => $order->getShippingCity() . '-' . $order->getShippingProvince() . '-' . $order->getShippingCountry(), //optional
            );

            //Fill invoice item array

            $invoiceItems = [];
            foreach ($order->getOrderDetails()->getValues() as $item) {
                $invoiceItems[] = [
                    'ItemName' => $item->getProduct(), //ISBAN, or SKU
                    'Quantity' => $item->getQuantity(), //Item's quantity
                    'UnitPrice' => ($item->getPrice() / 100), //Price per item
                ];
            }
            $invoiceItems[] = [
                'ItemName' => 'Delivery', //ISBAN, or SKU
                'Quantity' => 1, //Item's quantity
                'UnitPrice' => ($order->getDeliveryPrice() / 100), //Price per item
            ];
            if($order->getDiscountValue()){
                $invoiceItems[] = [
                    'ItemName' => 'Discount', //ISBAN, or SKU
                    'Quantity' => 1, //Item's quantity
                    'UnitPrice' => -$order->getDiscountValue(), //Price per item
                ];
            }
            //Fill POST fields array
//            dump((($order->getTotal() + $order->getDeliveryPrice()) / 100));
//            dump($invoiceItems);
//            die;
            $postFields = [
                //Fill required data
                'paymentMethodId' => $paymentMethodId,
                'InvoiceValue' => ($order->getTotalOrder() / 100),
                'CallBackUrl' => $YOUR_DOMAIN . '/'.$locale.'/order/thank/' . $order->getReference(),
                'ErrorUrl' => $YOUR_DOMAIN . '/'.$locale.'/order/error/' . $order->getReference(),
                'CustomerName' => $order->getShippingFullName(),
                'DisplayCurrencyIso' => 'KWD',
                'MobileCountryCode' => '+965',
                'CustomerMobile' => $order->getShippingPhone(),
                'CustomerEmail' => $order->getShippingEmail(),
                'Language' => 'en', //or 'ar'
                'CustomerReference' => $order->getReference(),
                'CustomerCivilId' => 'CivilId',
                'UserDefinedField' => '',
                'ExpiryDate' => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
                'SourceInfo' => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
                'CustomerAddress' => $customerAddress,
//                'InvoiceItems' => $invoiceItems,
            ];

            //Call endpoint
            $data = $this->executePayment($this->apiURL, $this->apiKey, $postFields);
            //You can save payment data in database as per your needs
            $paymentLink = $data->PaymentURL;
            $invoiceId = $data->InvoiceId;
            $invoiceKey = $this->get_string_between($data->PaymentURL, '=', '&');
            $order->setInvoiceId($invoiceId);
            $order->setInvoiceKey($invoiceKey);
            $entityManager->flush();
            return $this->redirect($paymentLink, 308);
        }else{
            if (!$order || !$this->transaction->check($order, 'pay_en_delivery'))
                return new JsonResponse(["error" => 'order']);
            $this->session->clear();
            $this->transaction->applyWorkFlow($order, 'pay_en_delivery');
            $order->setOrderedAt(new \DateTime());
            $order->setPaymentMethod("PAY EN DELIVERY");
            $this->mailer->sendSuccessOrderEmail($order);
            $this->mailer->sendReceivedOrderEmail($order);
            $this->entityManager->flush();
            return $this->redirectToRoute('order.validate.thank', ['locale' => $locale, 'reference'=> $order->getReference()]);
        }

        //Display the payment link to your customer
    }

    /* ------------------------ Functions --------------------------------------- */
    /*
     * Initiate Payment Endpoint Function
     */

    function initiatePayment($apiURL, $apiKey, $postFields)
    {

        $json = $this->callAPI("$apiURL/v2/InitiatePayment", $apiKey, $postFields);
        return $json->Data->PaymentMethods;
    }

//------------------------------------------------------------------------------
    /*
     * Execute Payment Endpoint Function
     */

    function executePayment($apiURL, $apiKey, $postFields)
    {

        $json = $this->callAPI("$apiURL/v2/ExecutePayment", $apiKey, $postFields);
        return $json->Data;
    }

    /*
     * Call API Endpoint Function
     */

    function callAPI($endpointURL, $apiKey, $postFields)
    {

        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die("Error: $error");
        }

        return json_decode($response);
    }

//------------------------------------------------------------------------------
    /*
     * Handle Endpoint Errors Function
     */

    function handleError($response): ?string
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
