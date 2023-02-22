<?php

namespace App\Mail;

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
    public function __construct($user, $month)
    {
        // dd($user);
        $this->user = $user;
        $this->company = $user->company_name;
        $this->id = $user->id;
        $this->email = $user->email;
        $this->month_of_request = $month;
        $this->date_of_request = Carbon::today()->format('Y/m/d');
        $this->year_month_of_last_month = Carbon::today()->subMonthsWithNoOverflow(1)->format('Y-m');
        $this->email_without_period = str_replace('.', '', $this->email);
        $this->document_file_name = 'invoice' . $this->year_month_of_last_month . $this->email_without_period . '.pdf';
        $this->invoice_id = count(Storage::allFiles('public')) - 1;
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
            <td rowspan="2" style="width:50%;">' . $this->company . '</td>
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
            <tr><th style="background-color:black;color:white;width:50%;">合計</th><td style="width:50%;">請求額円(税込み)</td></tr>
            </table>
            <table style="width:100%;margin:0 auto;">
            <tr><th style="width:30%;background-color:black;color:white;">商品名</th><th style="width:10%;background-color:black;color:white;">数量</th><th style="width:20%;background-color:black;color:white;">単位</th><th style="width:20%;background-color:black;color:white;">単価</th><th style="width:20%;background-color:black;color:white;">金額</th></tr>');
        // $count=0;
        // $document->WriteHTML($this->table_info);
        // dd($this->table_info);
        $product_names = Product::pluck('name', 'id');
        //今月購入したものが届いたか確認
        $all_orders = Order::where('user_id', $this->id)->whereMonth('delivery_date', $this->month_of_request - 1)->with('order_details')->get();
        $product_quantities_per_unit = Product::pluck('quantity', 'id');
        $product_price_per_unit = Product::pluck('price', 'id');
        $table_info = [];
        $count = 0;
        // $document->shrink_tables_to_fit;
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        $document->WriteHTML('<tr><th style="width:30%;"> 2 </th><th style="width:10%;"> 4 </th><th style="width:20%;"> 3 </th><th style="width:20%;"> 2 </th><th style="width:20%;">2 </th></tr>');
        // try {
        //     foreach ($all_orders as $orders) {
        //         foreach ($orders->order_details as $order) {
        //             //ここにif文で超えそうになったらpageadd
        //             $document->WriteHTML('<tr><th style="background-color:black;width:30%;">' . $product_names[$order->product_id] . '</th><th style="width:10%;">' . $order->quantity . '</th><th style="width:20%;">' . $product_quantities_per_unit[$order->product_id] . '</th><th style="width:20%;">' . $product_price_per_unit[$order->product_id] . '</th><th style="width:20%;">' . $product_price_per_unit[$order->product_id] . '</th></tr>');
        //         }
        //         $document->addPage();
        //     }
        // } catch (\Mpdf\MpdfException $e) {
        //     echo $e->getMessage();
        // }
        $document->WriteHTML('
                </table>
                hhhhhh
                </div>
        </section>
        ');

        Storage::disk('public')->put($this->document_file_name, $document->Output($this->document_file_name, "S"));
        return $this->text('emails.invoice')->from(env('MAIL_FROM_ADDRESS'))->with(['user' => $this->user])->attach(storage_path('app/public/' . $this->document_file_name));
    }
}
