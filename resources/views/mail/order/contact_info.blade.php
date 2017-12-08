
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
    <title>Đơn hàng thanh toán thành công</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:24px;
        line-height:24px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(4){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                Đơn hàng đã thanh toán thành công
                            </td>
                            
                            <td>
                                Invoice: #{{ substr($order->id, 0, 6) }}<br>
                                Created: {{ $order->created_at->format("Y-m-d") }}<br>
                                Due: {{ $order->created_at->format("Y-m-d") }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Công ty TNHH BELIAT - Dự án BWhere<br>
                                Tầng 5, toà nhà 72 Tây Sơn, Đống Đa, Hà Nội <br>
                            </td>
                            
                            <td>
                                {{ $order->name }}<br>
                                {{ $order->phonenumber }}<br>
                                {{ $order->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Nhà cung cấp</td>
                <td>Người liên hệ</td>
                <td>Điện thoại</td>
            </tr>

            @foreach ($order->information() as $item)
                @if ($item["type"] == "bus")
                <?php
                    $provider = $item["item"]->info->provider;
                    $manager = $provider->employees()->wherePivot('type_id', 1)->first();
                ?>
                <tr class="item">
                    <td>Vé {{ $item["item"]->info->name }}</td>
                    <td>{{ $provider->name_vi }}</td>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->phonenumber }}</td>
                </tr>
                @elseif ($item["type"] == "room")
                <?php
                    $hotel = $item["item"]->info->hotel;
                    $manager = $hotel->employees()->wherePivot('type_id', 1)->first();
                ?>
                <tr class="item">
                    <td>Phòng {{ $item["item"]->info->name }} - {{ $hotel->name }}</td>
                    <td>{{ $hotel->name_vi }}</td>
                    <td>{{ $manager->name }}</td>
                    <td>{{ $manager->phonenumber }}</td>
                </tr>
                @elseif ($item["type"] === "custom")
                <tr class="item">
                    <td>{{ $item["item"]->name_vi }}</td>
                    <td></td>
                    <td>{{ $item["item"]->info->name }}</td>
                    <td>{{ $item["item"]->info->phonenumber }}</td>
                </tr>
                @endif
            @endforeach
        </table>

        <a href="https://www.facebook.com/bwherevietnam/?ref=bookmarks" class="btn-primary" itemprop="url" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px; width: 100%; margin-top: 10px;">Hỗ trợ khi có bất kì sự cố gì</a>
    </div>
</body>
</html>
