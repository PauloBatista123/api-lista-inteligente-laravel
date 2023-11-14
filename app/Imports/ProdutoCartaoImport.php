<?php

namespace App\Imports;

use App\Http\Services\ProdutoService;
use App\Models\Cooperado;
use App\Models\ListaItem;
use App\Models\PontoAtendimento;
use App\Models\Produto;
use App\Models\Produto\Cartao;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;

class ProdutoCartaoImport implements ToCollection, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    use Importable, InteractsWithQueue, Queueable, SerializesModels, Trackable, RemembersChunkOffset;

    public array $log = [];
    public int $produto = 0;
    public int $listaId;
    protected ProdutoService $produtoService;

    public function __construct(int $produto, int $listaId)
    {
        $this->prepareStatus(['produto_id' => $produto]);
        $this->setInput(['status' => 'progress']);
        $this->produto = $produto;
        $this->listaId = $listaId;
        $this->produtoService = app(ProdutoService::class);
    }

    public function collection(Collection $rows)
    {
        $this->setProgressNow($this->getChunkOffset());

        foreach ($rows as $key => $row)
        {
            $this->incrementProgress();

            $validations = [
                'cpfcnpj' => $row['cpfcnpj'],
                'dataAberturaContaCartao' => $row['dataaberturacontacartao'],
                'pontoAtendimento' => $row['pontoatendimento'],
                'contaCartao' => $row['contacartao'],
                'produto' => $row['produto'],
                'faturamento' => $row['faturamento'],
                'valorLimiteAtribuido' => $row['valorlimiteatribuido'],
                'limiteAprovadoFabrica' => $row['limiteaprovadofabrica'],
            ];

            $validator = Validator::make($validations, [
                'cpfcnpj' => 'required',
                'dataAberturaContaCartao' => 'required',
                'contaCartao' => 'required',
                'pontoAtendimento' => 'required',
                'produto' => 'required',
                'faturamento' => 'required',
                'valorLimiteAtribuido' => 'required',
                'limiteAprovadoFabrica' => 'required',
            ]);

            if($validator->fails()){
                array_push($this->log, ['contacartao' => $row['contacartao'], 'status' => 'Processado com erros:'.implode(',', $validator->errors()->all())]);
                continue;
            }

            if(!$pontoAtendimento = PontoAtendimento::where('pa', $row['pontoatendimento'])->first()){
                array_push($this->log, ['contacartao' => $row['contacartao'], 'status' => 'Processado com erros: PA não existe']);
                continue;
            }

            $cpfReplace = str_replace('-', '', $row['cpfcnpj']);

            if(!$cooperado = Cooperado::where('cpf_cnpj', $cpfReplace)->first()){
                array_push($this->log, ['contacartao' => $row['contacartao'], 'status' => 'Processado com erros: Cooperado não existe']);
                continue;
            }

            $registro = Cartao::create(
                [
                    'conta_cartao' => $row['contacartao'],
                    'data_abertura_conta_cartao' => Carbon::createFromFormat("d/m/Y", $row['dataaberturacontacartao'])->toDateString() ?? null,
                    'limite_atribuido' => (float) $row['valorlimiteatribuido'] ?? null,
                    'limite_aprovado_fabrica' => (float) $row['limiteaprovadofabrica'] ?? null,
                ],
            );


            $this->produtoService->criar(
                $cooperado->id,
                $pontoAtendimento->id,
                $this->produto,
                Carbon::createFromFormat("d/m/Y", $row['movimento']),
                Cartao::class,
                $registro->id,
                $this->listaId
            );

            //array para setar no output do job
            array_push($this->log, ['contacartao' => $row['contacartao'], 'status' => 'Registro enviado']);
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
        return 1000;
    }
}

