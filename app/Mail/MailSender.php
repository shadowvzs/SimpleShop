<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSender extends Mailable {
    use Queueable, SerializesModels;

    protected $products;
    protected $cms;
    protected $client;

    public function __construct($products, $cms, $client) {
        $this->products = $products;
        $this->cms = $cms;
        $this->client = $client;
    }

    public function build() {
        $valami = 1;
        $masik = 2;
        return $this->view('email.order')
            ->with([
                'products' => $this->products,
                'cms' => $this->cms,
                'client' => $this->client,
        ]);
    }
}
