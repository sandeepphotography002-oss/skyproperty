<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Nayi enquiry ki ittila email par.
 *
 * Enquiry pehle database mein jaati hai, phir ye mail. Kram jaan-boojh
 * kar aisa hai: mail server band ho to bhi enquiry bachi rehti hai,
 * kyunki dashboard hi asli jagah hai. Mail sirf ek turant khabar hai.
 */
class EnquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Enquiry $enquiry)
    {
    }

    public function envelope(): Envelope
    {
        $e = $this->enquiry;

        /* Subject mein naam aur property, taaki inbox mein bina khole hi
           pata chal jaye ki kis cheez ki puchtaachh hai. */
        $what = $e->property_title ? ' — ' . $e->property_title : '';

        return new Envelope(
            subject: 'New enquiry: ' . $e->name . $what,

            /* Reply dabate hi seedha grahak ko jaye, hamein nahi. Isliye
               replyTo grahak ka email hai (agar diya ho). */
            replyTo: $e->email ? [$e->email] : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.enquiry');
    }
}
