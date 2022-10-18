<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, PasswordReset $reset)
    {
          //dd($emailToken);

        // $signedUrlData = parse_url_query_string(URL::signedRoute(
        //     'reset1-password',
        //     ['token' => $emailToken],
        // ));

        //$queryString = http_build_query(array_merge(['email_token' => $emailToken], $signedUrlData));

        $user = $this->url = config('settings.frontend_url')."/reset-password?";
        $this->user = $user;
        $this->reset = $reset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mails.Auth.passwords.reset-password');
    }
}
