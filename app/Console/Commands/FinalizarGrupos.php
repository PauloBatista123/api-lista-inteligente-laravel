<?php

namespace App\Console\Commands;

use App\Models\Lista;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FinalizarGrupos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lista:finalizar-grupos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica os grupos que possuem data de prazo expirado e altera o status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando atualização em massa...');

        Lista::where('status', 'ativa')->where('prazo_final', '<=' ,Carbon::now()->toDateTimeString())->update([
            'status' => 'finalizada'
        ]);

        $this->info('Atualização finalizada...');
    }
}
