<?php

namespace App\Mail;

use App\Models\DeliveryStatus;
use App\Models\Order;
use App\Models\Product;
use Exception;
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
    public function __construct($user,$string_for_pdf)
    {
        // dd($user);
        $this->user = $user;
        $this->name=$user->name;
        $this->company = $user->company_name;
        $this->id = $user->id;
        $this->month_of_request = Carbon::today()->format('m');
        $this->minus_one_month_year=Carbon::today()->subMonthNoOverflow()->format('Y');
        $this->minus_one_month_month=Carbon::today()->subMonthNoOverflow()->format('m');
        $this->year_of_request = Carbon::today()->format('Y');
        $this->date_of_request = Carbon::today()->format('Y/m/d');
        $this->year_month_of_last_month = Carbon::today()->subMonthNoOverflow()->format('Y-m');
        $this->email_without_period = str_replace('.', '', $user->email);
        // dd($user);
        $this->document_file_name = 'invoice' . $this->year_month_of_last_month . $this->email_without_period . '.pdf';
        $this->invoice_id = count(Storage::allFiles('public')) - 1;
        $this->string_for_pdf = $string_for_pdf;
    }
    //いまだとページ数の制限で無視される＝＞ページ数増やせばいいじゃないか＝＞どのタイミングでページどのくらい増やすのか？＝＞セル一個の立幅をとってページの長さで割ってページ数出力＝＞ページ数の制限なしになるメソッドないかな？

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
            'autoPageBreak' => true,
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
        $total_payment=Order::where('user_id',$this->id)->whereYear('delivery_date',$this->minus_one_month_year)->whereMonth('delivery_date',$this->minus_one_month_month)->where('delivery_status_id',DeliveryStatus::getDeliveredId())->sum('total_price');
        $total_payment_with_tax=$total_payment*1.1;
        $string = '';
        $string = $string . '<h1 style="width:100%;text-align:center;">請求書</h1>
        <section style="width:80%;margin:0 auto;">
        <table style="width:100%;">
        <tr>
            <td rowspan="2" style="width:50%;">' . $this->company . 'の'.$this->name.'様</td>
            <td style="width:50%;text-align:right;">No ' . $this->invoice_id . '</td>
            </tr>
                <tr>
                <td style="width:50%;text-align:right;">請求日 ' . $this->date_of_request . '</td>
                </tr>
                </table>
            <table style="width:100%;">
            <tr><th>下記の通り、御請求申し上げます。</th></tr>
            <tr><th style="background-color:black;color:white;width:50%;">件名</th><td style="width:50%;">今月の請求</td></tr>
            <tr><th style="background-color:black;color:white;width:50%;">支払期限</th><td style="width:50%;">' . Carbon::today()->addMonthsNoOverflow(1)->format('Y/m/t') . '</tr>
            <tr><th style="background-color:black;color:white;width:50%;">振込先</th><td style="width:50%;">' . env('BANK_ACCOUNT') . '</td></tr>
            <tr><th style="background-color:black;color:white;width:50%;">合計</th><td style="width:50%;">'.$total_payment_with_tax.'円(税込み)</td></tr>
            </table>
            <table style="width:100%;margin:0 auto;">
            <tr>
            <th style="width:30%;background-color:black;color:white;">
            商品名
            </th>
            <th style="width:10%;background-color:black;color:white;">
            数量
            </th>
            <th style="width:20%;background-color:black;color:white;">
            単位
            </th>
            <th style="width:20%;background-color:black;color:white;">
            単価
            </th>
            <th style="width:20%;background-color:black;color:white;">
            金額(税抜き)
            </th>
            </tr>
            ';
        $string = $string . $this->string_for_pdf;
        $string = $string . '
            </table>
            </div>
            </section>
            ';
        $document->WriteHTML($string);
        Storage::disk('public')->put($this->document_file_name, $document->Output($this->document_file_name, "S"));
        return $this->text('emails.invoice')->from(env('MAIL_FROM_ADDRESS'))->attach(storage_path('app/public/' . $this->document_file_name));
    }
}
