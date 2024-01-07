<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Notifications\ApplicationSubmitted;
use Twilio\Rest\Client;

class MembershipController extends Controller
{

  private $id = 1556; //Please change it with your ID
  private $key = "314889e6092227166b9358d47a8bb77ecf4f22f2";
  
  public function apply(Request $request)
  {
    $membership = new Membership;
    $membership->name = $request->name;
    $membership->email = $request->email;
    $membership->contact = $request->contact;
    $membership->reference = 'N/A';
    $membership->save();
    $this->sendWhatsapp($request->contact);
    $this->sendEmail($request->name, $request->email);
    return response()->json(['success' => 'Membership applied'], 200);
  }

  public function membershipApplicants()
  {
    $membership = Membership::get();
    return response()->json(['memberships'=>$membership]);
  }

  public function deleteApplicant($id)
  {
    Membership::findOrFail($id)->delete();
    return response()->json(['success'=>'Applicant Deleted']);
  }

  public function sendEmail($name, $email)
  {
    $to_name = $name;
    $to_mail = $email;
    $data = array('name'=>$name, "body" => "Your membership application has been submitted. You will be contacted by the authorities shortly");
    \Mail::send('emails.membership',$data, function($message) use ($to_name, $to_mail){
      $message->to($to_mail, $to_name)
      ->subject('Membership Applied');
      $message->from('thenzawlgolfresort@gmail.com', 'Membership Applied');
    });
  }

  public function sendWhatsapp($mobile_number)
  {
    $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_FROM');
    $account_sid = getenv("TWILIO_AUTH_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");

    $message = 'Thank you for your interest. We have received your application for membership. Our authorities will contact you shortly. Regards *Thenzawl Golf Resort*';

    $client = new Client($account_sid, $auth_token);

    // twilio active hunah hei hi hman tur
    // return $client->messages->create('whatsapp:+91'.$mobile_number, array('from' => "whatsapp:+".$twilio_whatsapp_number, 'body' => $message));

    // twilio active hma kan hmang ang
    return $client->messages->create('whatsapp:+91'.$mobile_number, array('from' => "whatsapp:+14155238886", 'body' => $message));
  }
  
  public function updateApplicationStatus(Request $request, $id)
  {
    $membership = Membership::findOrFail($id);
    $membership->staus = $request->status;
    $membership->save();
    return response()->json(['success'=>'Membership '.$request->status]);
  }
}
