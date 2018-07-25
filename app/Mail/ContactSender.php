<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactSender extends Mailable {
    use Queueable, SerializesModels;

    protected $cms;
    protected $client;

    public function __construct($cms, $client) {
        $this->cms = $cms;
        $this->client = $client;
    }


    public function build() {
      return $this->view('email.contact')
                     ->with([
                         'cms' => $this->cms,
                         'client' => $this->client,
                     ]);
    }
}
