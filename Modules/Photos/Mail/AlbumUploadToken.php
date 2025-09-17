<?php
namespace Modules\Photos\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlbumUploadToken extends Mailable
{
    use Queueable, SerializesModels;

    protected Album $album;
    protected UploadToken $uploadToken;

    public function __construct(Album $album, UploadToken $uploadToken)
    {
        Carbon::setLocale('fr');
        $this->album = $album;
        $this->uploadToken = $uploadToken;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à partager vos photos pour l\'album ' . $this->album->album_title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'photos::mail.album_upload_token',
            with: [
                'album' => $this->album,
                'uploadToken' => $this->uploadToken,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}