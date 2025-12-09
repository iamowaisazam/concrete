<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $phone, $messageText, $country, $city, $postal_code, $address, $profession;

    public function __construct($name, $email, $messageText, $phone, $country, $city, $postal_code, $address, $profession)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->messageText = $messageText;
        $this->country = $country;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->address = $address;
        $this->profession = $profession;
    }

    public function build()
    {
        return $this->subject('New Contact Form Submission')
            ->view('emails.contact')
            ->cc(env('ADMIN_EMAIL'));
    }
}

