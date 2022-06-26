<?php



namespace App\Http\Middleware;

use Closure;
use App\Reserva;
use App\User;
use Illuminate\Support\Facades\Mail;
use \App\Mail\Reserva_Atraso;
use \App\Mail\NovosAtrasosToFuncionarios;





class CheckDates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $reservas = Reserva::checkdates();
        $funcionarios = User::GestoresDeReservas();

        foreach ($reservas as $reserva) {
            $userReserva = User::findOrFail($reserva->user_id);

            Mail::to($userReserva->email)
                ->send(new Reserva_Atraso($reserva));

            foreach ($funcionarios as $value) {

                foreach ($value as $user) {
                    Mail::to($user->email)
                        ->send(new NovosAtrasosToFuncionarios($reserva, $userReserva));
                    sleep(2);
                }
            }
        }

        return $next($request);
    }
}
