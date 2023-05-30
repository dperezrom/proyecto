<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->greeting('¡Hola!')
                ->subject('Verificar la dirección de correo electrónico')
                ->line('Haga clic en el botón de abajo para verificar su dirección de correo electrónico')
                ->action('Verificar la dirección de correo electrónico', $url)
                ->line('Saludos,')
                ->salutation('Doñana SHOP');
        });
    }
}
