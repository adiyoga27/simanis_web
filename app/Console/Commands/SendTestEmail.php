<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpForgetPassEmail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:test {email? : Alamat email tujuan} {--driver= : Mail driver override}';

    protected $description = 'Kirim email uji coba untuk memverifikasi konfigurasi mail';

    public function handle()
    {
        $email = $this->argument('email');

        if (!$email) {
            $defaultEmail = config('mail.from.address');
            $email = $this->ask('Masukkan alamat email tujuan', $defaultEmail);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error("Alamat email '$email' tidak valid.");
            return Command::FAILURE;
        }

        if ($driver = $this->option('driver')) {
            config(['mail.default' => $driver]);
        }

        $mailer = config('mail.default');
        $host = config("mail.mailers.{$mailer}.host");
        $port = config("mail.mailers.{$mailer}.port");
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name', config('app.name'));

        $this->newLine();
        $this->info("=== Konfigurasi Mail Saat Ini ===");
        $this->table(
            ['Setting', 'Value'],
            [
                ['Driver/Mailer', $mailer],
                ['Host', $host],
                ['Port', $port],
                ['Encryption', config("mail.mailers.{$mailer}.encryption") ?: '-'],
                ['Username', config("mail.mailers.{$mailer}.username") ?: '-'],
                ['From Address', $fromAddress],
                ['From Name', $fromName],
            ]
        );

        $this->newLine();
        $this->line("<comment>Mengirim email uji coba ke: {$email}...</comment>");

        try {
            Mail::to($email)->send(new SendOtpForgetPassEmail($email, 'TEST123'));

            $this->newLine();
            $this->info('Email berhasil dikirim! Silakan cek inbox/spam di ' . $email);

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('Gagal mengirim email!');
            $this->error("Error: {$e->getMessage()}");

            if ($this->option('verbose')) {
                $this->newLine();
                $this->line("<fg=gray>{$e->getTraceAsString()}</>");
            }

            return Command::FAILURE;
        }
    }
}
