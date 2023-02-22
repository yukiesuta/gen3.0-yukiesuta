<?php

namespace App\Http\Controllers;

use App\Mail\invoice_mail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class test extends Controller
{
    public function sendmail()
    {
        $all_customers = User::where('role_id',Role::getUserId())->get();
        foreach($all_customers as $customer){
            Mail::to($customer)->send(new invoice_mail($customer));
        }
    }
}
