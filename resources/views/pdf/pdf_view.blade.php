<!--<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test</title>
</head>
<body>
  Please Save This QR Code
  <br>
  {!! $data['qr'] !!}
</body>
</html>-->


<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Receipt</title>
  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #fff;
    }

    .Receipt-for-Thenzawl-receipt {
      width: 100%;
      padding: 20px;
      box-sizing: border-box;
    }

    .Rectangle-1879 {
      width: 100%;
      max-width: 370px;
      /* Adjust the maximum width as needed */
      margin: 0 auto;
      padding: 20px;
      border: solid 0.5px #707070;
      background-color: #fff;
      height: 820px;
    }

    .details {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    /* Add this new CSS class */
    .detail-item {
      width: 49%;
      /* To fit two items side by side */
      margin-bottom: 10px;
      /* Adjust margin as needed */
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    img.Mask-Group-193 {
      width: 152.5px;
      height: 50.5px;
      margin: 0 32px 6px 1px;
      object-fit: contain;
    }

    .time-1030-AM {
      width: 208.5px;
      height: 14px;
      margin: 6px 5px 14.5px 7.8px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }

    .Rectangle-1881 {
      /* display: flex;
            justify-content: center */
      position: relative;
      width: 180px;
      height: 51.5px;
      margin: 21.5px 1px 11.5px 0;
      padding: 16px 90.5px 14px;
      border-radius: 11.5px;
      border: dashed 2px #646262;
    }

    .Order-ID {
      position: absolute;
      left: 41px;
      bottom: 64px;
      padding-right: 18px;
      padding-left: 18px;
      background-color: #fff;
      width: 59px;
      /* height: 14px; */
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: 2px;
      text-align: left;
      color: #030303;
    }

    .DP-1629312264 {
      position: absolute;
      right: 123px;
      width: 113px;
      height: 21.5px;
      font-family: Poppins;
      font-size: 15px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #030303;
    }

    .c {
      display: flex;
      align-items: flex-start;
    }

    .e {
      display: flex;
      justify-content: center
    }

    .e img {
      width: 148px;
      height: 148px;
    }

    .text-right {
      width: 101.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }

    .Payment-Type {
      width: 72.5px;
      height: 14px;
      margin: 11.5px 8.5px 14.5px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .UPI {
      width: 101.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;

    }

    hr {
      border-top: 1px dashed #646262;
    }


    .Line-22 {
      width: 293.5px;
      height: 0.5px;
      margin: 14.5px 0.8px;
      background-color: #979292;
    }

    .Customer-Name {
      width: 83px;
      height: 14px;
      margin: 14.5px 12.5px 10px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .John-Lallianzuala-Chhakchhuak {
      width: 101.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }


    .Email-ID {

      width: 40px;
      /* width133.5px; */
      height: 14px;
      margin: 10px 24.5px 10px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }


    .johnlzchmailcom {
      width: 133.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }

    .Contact-No {
      width: 59.5px;
      height: 14px;
      margin: 10px 5px 14.5px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Line-23 {
      width: 293.5px;
      height: 0.5px;
      margin: 14.5px 1.5px 14.5px 0;
      background-color: #979292;
    }


    span {
      /* text-align: right !important; */
      width: 101.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }

    .ITEMS {
      width: 28.5px;
      height: 14px;
      margin: 14.5px 7.8px 7.5px 6.8px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }



    .Log-Hut {
      width: 37.5px;
      height: 14px;
      margin: 7.5px 27.5px 10px 7px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }


    .Date-From {
      width: 52px;
      height: 14px;
      margin: 10px 13px 10px 7px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .ddmmyyyy {
      width: 115.5px;
      height: 14px;
      margin: 10px 12.5px 10px 90.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 600;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: right;
      color: #030303;
    }

    .Date-To {
      width: 38.5px;
      height: 14px;
      margin: 10px 26.5px 10px 7px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Expected-Arrival {
      width: 81px;
      height: 14px;
      margin: 10px 0 10px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .No-of-Children {
      width: 73.5px;
      height: 14px;
      margin: 10px 7.5px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .No-of-Adults {
      width: 63px;
      height: 14px;
      margin: 10px 1px 9.8px 8px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Line-24 {
      width: 293.5px;
      height: 0.5px;
      margin: 9.8px 1.5px 14.5px 0;
      background-color: #979292;
    }

    .Rate-in-Rs {
      width: 59px;
      height: 14px;
      margin: 14.5px 6.3px 10.3px 6.8px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Amount-in-Rs {
      width: 76.5px;
      height: 14px;
      margin: 10.3px 5px 10px 7px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }


    .Discount {
      width: 44px;
      height: 14px;
      margin: 10px 21px 10px 7px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Line-25 {
      width: 293.5px;
      height: 0.5px;
      margin: 10px 1.5px 14.5px 0;
      background-color: #979292;
    }

    .Grand-Total {
      width: 59.5px;
      height: 14px;
      margin: 11.5px 5.8px 5px 6.8px;
      font-family: Poppins;
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: normal;
      letter-spacing: normal;
      text-align: left;
      color: #8e8c8c;
    }

    .Image-1 {
      width: 55.5px;
      height: 55.5px;
      margin: 27.5px 5.5px 3.5px 0;
      object-fit: contain;
    }


    img.Mask-Group-194 {
      width: 85px;
      height: 40px;
      margin: 3.5px 27px 3px 16.5px;
      object-fit: contain;
    }


    .Golf-Course-Country-Club-Thenzawl-Serchhip-India-Mizoram-91-389-233-3475-thenzawlgolfresor {
      width: 289px;
      height: 23px;
      margin: 3px 0 0 6px;
      font-family: Poppins;
      font-size: 9px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: 1.17;
      letter-spacing: normal;
      text-align: center;
      color: #242424;
    }
  </style>
</head>

<body>
  <div class="Receipt-for-Thenzawl-receipt">

    <div class="Rectangle-1879">
      <center>
        <img src="{{ public_path('assets/img/Logo1.png')  }}" alt="Logo" class="Mask-Group-193">
      </center>

      <!-- <div class="Wed-Mar-23-2023-1030-AM">
        <span class="">
          {{$date ?? " "}}
        </span>
        <span class="">
          {{$time ?? " "}}
        </span>
      </div> -->

      <div class="Rectangle-1881">
        <span class="Order-ID">
          Order ID
        </span>
        <span class="DP-1629312264">
          {{ $order_id ?? "N/A" }}
        </span>
      </div>

      <div class="c">
        <span class="Payment-Type">
          Payment Type
        </span>

        <span class="UPI">
          {{ $payment_mode ?? "N/A" }}
        </span>
      </div>
      <hr>


      <div class="c">
        <span class="Customer-Name">
          Customer Name
        </span>
        <span class="John-Lallianzuala-Chhakchhuak">
          {{ $order_name ?? "N/A" }}
        </span>
      </div>


      <div class="c">
        <span class="Email-ID">
          Email ID
        </span>
        <span class="johnlzchmailcom">
          {{ $order_email ?? "N/A" }}
        </span>
      </div>


      <div class="c">
        <span class="Contact-No">
          Contact No.
        </span>
        <span class="johnlzchmailcom">
          {{ $order_contact ?? "N/A" }}
        </span>
      </div>
      <hr>



      <span class="ITEMS">
        ITEMS
      </span>
      <br>
      <div class="c">
        <span class="Log-Hut">
          {{ $name_of_item ?? "N/A" }}
        </span>
        <span class="johnlzchmailcom">
          {{ $quantity ?? "N/A"  }}
        </span>
      </div>
      <div class="c">
        <span class="Date-From">
          Date From
        </span>
        <span class="johnlzchmailcom">
          {{ $date_from ?? "N/A" }}
        </span>
      </div>
      <div class="c">
        <span class="Date-To">
          Date To
        </span>
        <span class="johnlzchmailcom">
          {{ $date_to ?? "N/A" }}
        </span>
      </div>

      <div class="c">
        <span class="Expected-Arrival">
          Expected Arrival
        </span>
        <span class="ddmmyyyy">
          {{ $expected_arrival ?? "N/A"}}
        </span>
      </div>

      <div class="c">
        <span class="No-of-Children">
          No. of Child
        </span>
        <span class="ddmmyyyy">
          {{ $no_of_children ?? "N/A" }}
        </span>
      </div>
      <div class="c">
        <span class="No-of-Adults">
          No. of Adult
        </span>
        <span class="johnlzchmailcom">
          {{ $no_of_adults ?? "N/A" }}
        </span>
      </div>
      <hr>

      <div class="c">
        <span class="Rate-in-Rs">
          Rate (in Rs)
        </span>
        <span class="johnlzchmailcom">
          {{ $rates ?? "N/A"}}
        </span>
      </div>
      <div class="c">
        <span class="Amount-in-Rs">
          Amount (in Rs)
        </span>
        <span class="ddmmyyyy">
          {{ $amount ?? "N/A"}}
        </span>
      </div>
      <div class="c">
        <span class="Discount">
          Discount
        </span>
        <span class="johnlzchmailcom">
          {{ $discount_value ?? "N/A"}}
        </span>
      </div>
      <hr>

      <div class="c">
        <span class="Grand-Total">
          Grand Total
        </span>
        <span class="johnlzchmailcom">
          {{ $mer_amount ?? "N/A" }}
        </span>
      </div>
      <div class="e">
        <center>
          <h2>{!! $data['qr'] !!}</h2>
          <img src="{{public_path('assets/img/Logo1.png') }}" alt='logo' class="Mask-Group-194">
        </center>
      </div>
      <center>
        <div class="e">
          <span class="Golf-Course-Country-Club-Thenzawl-Serchhip-India-Mizoram-91-389-233-3475-thenzawlgolfresor">
            Golf Course & Country Club · Thenzawl, Serchhip, India, Mizoram<br>
            +91 389 233 3475 · thenzawlgolfresort@gmail.com
          </span>
        </div>
      </center>


    </div>

  </div>

</body>

</html>
