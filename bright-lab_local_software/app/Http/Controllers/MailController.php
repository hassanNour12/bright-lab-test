<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function send_email($rows_num,$date) {
      try {
         $data = array('rows_num'=>$rows_num,'date'=>$date);
     
         Mail::send(['text'=>'pages.mail.mail'], $data, function($message) {
            $message->to('mrx.test.brightlab@gmail.com', 'Mr x')->subject
               ('Data Syncing from offline database to online database');
            $message->from('noreply.brightlab@gmail.com','Bright-lab');
         });
         return redirect('sync')->with('success',"Successfully Synced");
      }catch(Exception $e){
         // dd($e);
         return redirect('sync')->with('email_failed',"Successfully Synced..But Failed to Send Email");
      }
        
     }
}
