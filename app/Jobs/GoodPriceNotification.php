<?php

namespace App\Jobs;

use App\User;
use Autologin;
use App\Product;
use App\Watchinglist;
use App\Pricenotification;
use App\Mail\LowerPriceNotification;
use Illuminate\Support\Facades\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class GoodPriceNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()    // Per ogni ASIN --> confronta i prezzi in 'Product' table (1) con prezzi in 'Watchinglist' table (2). 
                                // SE (1) < (2) ALLORA invia notifica a user_id
    {   
        $users_array = Watchinglist::groupBy('user_id')->select('user_id')->get(); //all()->groupBy('user_id');
        //dd($users_array);

        $awsaccesskeyid = env('AWS_ACCESS_KEY_ID');
        // dd($awsaccesskeyid);

        foreach ($users_array as $user) {       //dump($user->user_id);   // 2 4 25

            $mail = false;
            $watching_items = Watchinglist::where('user_id', $user->user_id)->where('removed', 0)->get();       //dd($watching_items);
            $list = '';
            $count = 0;

            foreach ($watching_items as $item) {
            
                $user_id = $item->user_id;
                $initial_price = $item->initialprice;
                $current_price = $item->product->lowestnewprice;  //!! foreignKey !!

                //$new_product = $item->product->created_at; // notificare anche se ci sono nuovi prodotti in db
                //dd($new_product);

                $target_price = $initial_price - 1.00;  // impostare i criteri per definire un obbiettivo di prezzo es: -10% o -10.00 o ...
                
                //echo 'user_id: '. $user_id . "\r\n";
                //echo 'initial_price: '. $initial_price . "\r\n";
                //echo 'current_price: '. $current_price . "\r\n";
                //echo 'target_price: '. $target_price . "\r\n";

                

                if ($current_price <= $target_price) {
                    $mail = true;       // var_dump($mail);  
                    $list .= '<li style="margin-bottom:25px;"><b>'.$item->product->title . '</b>.<ul style="padding-left: 0px;"><li>Il prezzo iniziale era: € '. number_format($item->initialprice, '2', ',', '.') .'</li><li>Il prezzo corrente è: <b>€ ' . number_format($item->product->lowestnewprice, '2', ',', '.').'</b>&nbsp;&nbsp;<a style="font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; display: inline-block; min-height: 18px; padding: 3px 10px; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px; text-align: center; text-decoration: none; -webkit-text-size-adjust: none; background-color: #22BC66;" class="button" href="http://www.amazon.it/gp/aws/cart/add.html?AWSAccessKeyId=' . $awsaccesskeyid . '&AssociateTag=infsol-21&ASIN.1=' . $item->product->asin . '&Quantity.1=1" target="_blank">Acquista subito</a></li></ul></li>';
                    //dump($list);
                    $count++;
                }
                
                
            } // fine ciclo item
            
            if ($mail === true && Pricenotification::isInTodayPricenotificationList($user->user_id) === false ) { // evita doppia notifica per utente  


                try {

                    $name = $user->user->name;  // !!foreign key !!

                    // Autologin link for a user with a path es: http://example.com/autologin/RvcNoAcH0X  // User class implements UserInterface
                    $user_autologin = User::find($user->user_id);
                    $link = Autologin::to($user_autologin, '/backend#my-list');
                    $link_home = Autologin::to($user_autologin, '/videocitofoni/comparatore-prezzi');
                    $user_id = $user->user_id;

                    Mail::to($user->user->email)
                        ->bcc(env('ADMIN_EMAIL'))
                        ->queue(new LowerPriceNotification($name, $list, $count, $link, $link_home, $user_id));

                } catch(Exception $e) {

                    return $e->getMessage();

                }


                // SE INVIO MAIL È ANDATO A BUON FINE --> AGGIORNA "pricenotifications" IN DB
                $inserted = Pricenotification::insertInPricenotificationList($user->user_id);

                // ripulisci i vecchi records
                $cleaned = Pricenotification::cleanOldPricenotificationList();
                
                          
            }   //else { dd('non invia mail'); }

            sleep(2);

        } //fine ciclo utente       
        
                
        return;
    }
}
