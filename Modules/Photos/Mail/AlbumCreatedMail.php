<?php

namespace Modules\Photos\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Modules\Photos\Models\Album;
use Carbon\Carbon;

class AlbumCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Album $album;

    public function __construct(Album $album)
    {
        Carbon::setLocale('fr');
        
        $album->wedding_date = Carbon::parse($album->wedding_date);
        if ($album->opens_at) {
            $album->opens_at = Carbon::parse($album->opens_at);
        }
        $this->album = $album;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Album créé avec succès',
        );
    }

     /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'photos::mail.album_created',
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