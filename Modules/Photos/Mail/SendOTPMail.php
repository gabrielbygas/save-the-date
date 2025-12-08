<?php

namespace Modules\Photos\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Modules\Photos\Models\OTP;
use Carbon\Carbon;
 
class SendOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public OTP $otp;

    public function __construct(OTP $otp)
    {
        Carbon::setLocale('fr');
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code OTP pour accéder aux albums photos',
        );
    }

     /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'photos::mail.send_otp',
        );
    }

     /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}