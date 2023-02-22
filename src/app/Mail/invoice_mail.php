<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class invoice_mail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        // dd($user);
        $this->user = $user;
        $this->id = $user->id;
        $this->email = $user->email;
        $this->date_of_request = Carbon::today()->format('Y/m/d');
        $this->year_month_of_last_month = Carbon::today()->subMonthsWithNoOverflow(1)->format('Y-m');
        $this->email_without_period = str_replace('.', '', $this->email);
        $this->document_file_name = 'invoice' . $this->year_month_of_last_month . $this->email_without_period . '.pdf';
        $this->invoice_id = count(Storage::allFiles('public')) - 1;
        $all_orders = Order::where('user_id', $this->id)->with('order_details')->get();
        dd($all_orders);
        // $this->all_orders=
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $document = new mPDF([
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
            'fontdata' => [
                'sun-exta' => [
                    'R' => 'Sun-ExtA.ttf'
                ]
            ]
        ]);
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->document_file_name . '"'
        ];
        $document->WriteHTML('
        <h1 style="color:blue;width:100%;text-align:center;">請求書</h1>
        <section style="width:80%;margin:0 auto;">
            <table style="width:100%;">
            <tr>
            <td rowspan="2" style="width:50%;">サンプル株式会社</td>
            <td style="width:50%;text-align:right;">No '.$this->invoice_id.'</td>
            </tr>
                <tr>
                <td style="width:50%;text-align:right;">請求日 '.$this->date_of_request.'</td>
                </tr>
            </table>
            <table style="width:100%;">
            <tr><th>下記の通り、</th><th>御請求申し上げます。</th></tr>
            <tr><th style="background-color:black;color:white;">件名</th><td>今月の請求</td></tr>
            <tr><th style="background-color:black;color:white;">支払期限</th><td>'.Carbon::today()->addMonthsNoOverflow(1)->format('Y/m/t').'</tr>
            <tr><th style="background-color:black;color:white;">振込先</th><td>'.env('BANK_ACCOUNT').'</td></tr>
            <tr><th style="background-color:black;color:white;">合計</th><td>請求額円(税込み)</td></tr>
            </table>
            <table>
            <tr><th>摘要</th><th>数量</th><th>単位</th><th>単価</th><th>金額</th></tr>
            ' . $all_orders . '
                </table>
                </div>
        </section>
        ');
        
        Storage::disk('public')->put($this->document_file_name, $document->Output($this->document_file_name, "S"));
        return $this->text('emails.invoice')->from(env('MAIL_FROM_ADDRESS'))->with(['user' => $this->user])->attach(storage_path('app/public/' . $this->document_file_name));
    }
}
