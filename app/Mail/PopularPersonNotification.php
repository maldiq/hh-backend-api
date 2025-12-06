<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PopularPersonNotification extends Mailable
{
    public $person;
    public function __construct($person){ $this->person = $person; }
    public function build(){
        return $this->subject("Person received >50 likes")->view('emails.popular_person')->with(['person'=>$this->person]);
    }
}
