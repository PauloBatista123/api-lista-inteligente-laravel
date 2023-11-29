<?php

namespace App\Imports;

use App\Models\Cooperado;
use App\Models\PontoAtendimento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;

class CooperadoImport implements ToCollection, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    use Importable, InteractsWithQueue, Queueable, SerializesModels, Trackable, RemembersChunkOffset;

    public $log = [];

    public function __construct()
    {
        $this->prepareStatus();
        $this->setInput(['status' => 'progress']);
    }

    public function collection(Collection $rows)
    {
        $this->setProgressNow($this->getChunkOffset());

        foreach ($rows as $key => $row)
        {
            $this->incrementProgress();

            $validations = [
                'nome' => $row['nome'],
                'cpfcnpj' => $row['cpfcnpj'],
                'telefoneCelular' => $row['telefonecelular'],
                'telefoneResidencial' => $row['telefoneresidencial'],
                'pontoAtendimento' => $row['pontoatendimento'],
                'endereco' => $row['endereco'],
                'telefoneResidencial' => $row['telefoneresidencial'],
                'cidade' => $row['cidade'],
                'uf' => $row['uf'],
                'renda' => $row['renda'],
                'sigla' => $row['sigla'],
            ];

            $validator = Validator::make($validations, [
                'nome' => 'required',
                'cpfcnpj' => 'required',
                'telefoneCelular' => 'required',
                'pontoAtendimento' => 'required',
                'endereco' => 'required',
                'cidade' => 'required',
                'uf' => 'required',
                'renda' => 'required',
                'sigla' => 'required',
            ]);

            if($validator->fails()){
                array_push($this->log, ['cpfcnpj' => $row['cpfcnpj'], 'status' => 'Processado com erros:'.implode(',', $validator->errors()->all())]);
                continue;
            }

            if(!$pontoAtendimento = PontoAtendimento::where('pa', $row['pontoatendimento'])->first()){
                array_push($this->log, ['cpfcnpj' => $row['cpfcnpj'], 'status' => 'Processado com erros: PA não existe']);
                continue;
            }

            $cpfReplace = str_replace('-', '', $row['cpfcnpj']);

            DB::table('cooperados')->updateOrInsert(
                [
                    'cpf_cnpj' => $row['cpfcnpj'],
                ],
                [
                    'nome' => $row['nome'],
                    'cpf_cnpj' => $cpfReplace,
                    'telefone_celular' => $row['telefonecelular'] ?? null,
                    'telefone_residencial' => $row['telefoneresidencial'] ?? null,
                    'endereco' => $row['endereco'] ?? null,
                    'cidade' => $row['cidade'] ?? null,
                    'sigla' => $row['sigla'] ?? null,
                    'renda' => (float) $row['renda'] ?? null,
                    'uf' => $row['uf'] ?? null,
                    'ponto_atendimento_id' => $pontoAtendimento->id,
                ],
            );

            //array para setar no output do job
            array_push($this->log, ['cpfcnpj' => $row['cpfcnpj'], 'status' => 'Registro enviado']);
        }
        $this->setOutput(['registros' => $this->log, 'error' => false]);
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $this->setProgressMax((int) $event->getReader()->getTotalRows()["Plan1"]);
            },
            ImportFailed::class => function(ImportFailed $event) {
                $this->setOutput(['registros' => $this->log, 'error' => $event->getException()->getMessage()]);
                $this->setInput(["status" => "error"]);
            },
            AfterImport::class => function (AfterImport $event) {
                $this->setInput(["status" => "finished"]);
            }
        ];
    }

    public function chunkSize(): int
    {
        return 5000;
    }
}
