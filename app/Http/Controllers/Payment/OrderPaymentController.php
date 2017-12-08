<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_history;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;

use App\Mail\OrderContactInformation;
use Mail;
use App\Notifications\OrderPaid;
use Notification;

class OrderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($order_id)
    {
        if ($order_id == "ipn")
        {
            $params = array();
            $returnData = array();
            $data = $_REQUEST;
            foreach ($data as $key => $value) {
                if(substr($key,0,3)=="vnp")
                {
                    $params[$key] = $value;
                }
            }
            $vnp_SecureHash = $params['vnp_SecureHash'];
            unset($params['vnp_SecureHashType']);
            unset($params['vnp_SecureHash']);
            ksort($params);
            $i = 0;
            $hashData = "";
            foreach ($params as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . $key . "=" . $value;
                } else {
                    $hashData = $hashData . $key . "=" . $value;
                    $i = 1;
                }
            }
            $secureHash = md5(env("VNP_HASH_SECRET") . $hashData);
            $Status = 0;
            $Id = $params[ 'vnp_TxnRef' ];
            $order = Order::wherePaymentId($Id)->first();
            try {
                if ($order)
                {
                    if ($secureHash == $vnp_SecureHash)
                    {
                        if ($order->status_id != 4)
                        {
                            if ($params['vnp_ResponseCode'] == '00') {
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                                $returnData['Signature'] = $secureHash;
                                $Status = 1;
                                if ($params['vnp_BankCode'] == "VISA")
                                {
                                    $order->system_balance_id = "858a41547d4e4259bc33440161c17dad";
                                }
                                else
                                {
                                    $order->system_balance_id = "bd006e022476425d8c77ce93296d0bfc";
                                }
                                
                                $order->vnp_transaction_no = $params['vnp_TransactionNo'];
                                $order->save();
                                $history = new Order_history;
                                $history->status_id = 4;
                                $history->message = "Auto update with vnpay";
                                $history->order_id = $order->id;
                                $history->save();

                                Mail::to($order->email)->send(new OrderContactInformation($order->id));
                                Notification::send(User::withRole("admin")->get(), new OrderPaid($object));

                            } else {
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                                $returnData['Signature'] = $secureHash;
                                $Status = 2;
                            }
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '97';
                        $returnData['Message'] = 'Chu ky khong hop le';
                        $returnData['Signature'] = $secureHash;
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } catch (Exception $e) {
                $returnData['RspCode'] = '99';
                $returnData['Message'] = 'Unknow error';
            }
            return response()->json($returnData);
        }
        else
        {
            $uuid = str_replace("-", "", Uuid::generate());
            $order = Order::findOrFail($order_id);
            $order->payment_id = $uuid;
            $order->save();

            $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
            $vnpay_hash_secret = env("VNP_HASH_SECRET");

            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_TmnCode" => env("VNP_TMN_CODE"),
                "vnp_Amount" => (int)($order->total_price * 100),
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toan don hang $order->id",
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => "http://localhost",
                "vnp_TxnRef" => $uuid,
                "vnp_Version" => "2.0.0",
                "vnp_BankCode" => request()->payment_method,
                );
            $out = $inputData;
            ksort($out);

            $i = 0;
            $hashdata = "";
            $query = "";
            foreach ($out as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnpay_hash_secret)) {
                $vnpSecureHash = md5($vnpay_hash_secret . $hashdata);
                $vnp_Url .= 'vnp_SecureHashType=MD5&vnp_SecureHash=' . $vnpSecureHash;
            }
            return redirect($vnp_Url);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view("backend.order.invoice_customer", ["order" => $order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
