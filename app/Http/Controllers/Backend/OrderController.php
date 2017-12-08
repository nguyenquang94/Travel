<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Balance;
use App\Mail\OrderInformation;
use App\Mail\OrderContactInformation;
use Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.order.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has("user_id"))
        {
            $user = User::findOrFail($request->user_id);
            return view("backend.order.add", ["user" => $user]);
        }
        return view("backend.order.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->fill($request->all());
        $order->save();

        return redirect("/order/$order->id/edit");
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
        $order = Order::with("items")->findOrFail($id);
        $order->update_price();
        return view("backend.order.add", ["order" => $order]);
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
        $order = Order::findOrFail($id);
        $order->fill($request->all());
        $order->save();

        return redirect("/order/$order->id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect("/order");
    }

    public function getSendPaymentMethod($id)
    {
        $order = Order::findOrFail($id);
        $user = $order->user;

        $balances = Balance::system()->get();
        $buttons = [];
        foreach ($balances as $balance)
        {
            $buttons[] = [
                "type" => "postback",
                "title" => $balance->bank->shortname,
                "payload" => "DEVELOPER_DEFINED_PAYLOAD"
            ];
        }

        $user->send_fb_message([
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "button",
                    "text" => "Bạn muốn thanh toán bằng hình thức nào?",
                    "buttons" => $buttons,
                ]
            ]
        ]);

        return redirect()->back();
    }

    public function getSendOrderMail($id)
    {
        $order = Order::findOrFail($id);
        Mail::to($order->email)->send(new OrderInformation($id));
        return redirect()->back();
    }

    public function getSendOrderContactMail($id)
    {
        $order = Order::findOrFail($id);
        Mail::to($order->email)->send(new OrderContactInformation($id));
        return redirect()->back();
    }

    public function getSendOrderLBFBC($id)
    {
        $order = Order::findOrFail($id);
        $user = $order->user;

        $infos = $order->information();
        
        $elements = [];
        foreach ($infos as $info)
        {
            $elements[] = [
                "title" => $info["name"],
                "subtitle" => $info["start"]->format("d-M-Y"),
                "quantity" => $info["count"],
                "price" => $info["price"],
                "currency" => "VND"
            ];
        }

        $user->send_fb_message([
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "receipt",
                    "recipient_name" => $order->name,
                    "order_number" => $order->id,
                    "currency" => "VND",
                    "payment_method" => $order->payment_method ? $order->payment_method->bank->shortname : "Unknown",
                    "elements" => $elements,
                    "summary" => [
                        "total_cost" => $order->items()->sum("price"),
                    ]
                ]
            ]
        ]);
        return redirect()->back();
    }

    public function getUpdateTransaction($id)
    {
        $order = Order::findOrFail($id);
        $order->update_transaction();
        return redirect()->back();
    }
}
