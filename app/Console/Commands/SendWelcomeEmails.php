<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmails extends Command
{
    protected $signature = 'app:send-welcome-emails';
    protected $description = 'Envia emails de binevenida a usuarios no verificados';

    public function handle()
    {
        $users = User::whereNull('email_verified_at')
            ->where('id', '!=', 1)
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new WelcomeMail($user));
            $this->info("Welcome email sent to {$user->email}");
        }

        return Command::SUCCESS;
    }
}
