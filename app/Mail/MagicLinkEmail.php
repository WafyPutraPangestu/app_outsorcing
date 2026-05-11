<?php

namespace App\Mail;

use App\Models\EvaluasiToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public EvaluasiToken $tokenData;
    public $url;

    /**
     * Menerima data token dari Livewire saat dikirim.
     */
    public function __construct(EvaluasiToken $tokenData)
    {
        $this->tokenData = $tokenData;

        // Membangun URL lengkap berdasarkan nama rute yang baru kita buat
        // Hasilnya: https://domain-kamu.com/evaluasi/form/123e4567-e89b-12d3...
        $this->url = route('klien.evaluasi', ['token' => $tokenData->token]);
    }

    /**
     * Mengatur subjek/judul email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permintaan Evaluasi Kinerja Karyawan - PT Valdo',
        );
    }

    /**
     * Menghubungkan ke template Blade HTML.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.magic-link',
        );
    }
}
