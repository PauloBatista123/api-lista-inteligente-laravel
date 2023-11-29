<?php

namespace App\Http\Services;

use App\Http\Interfaces\TabelaProdutos;
use App\Imports\CooperadoImport;
use App\Imports\Limites\ProdutoLimiteCooperadoSemLimiteImport;
use App\Imports\ProdutoCartaoImport;
use App\Imports\ProdutoCooperadoComLimiteBloqueioImport;
use App\Imports\ProdutoCooperadoSemLimiteImport;
use App\Models\Produto;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ImportacaoService {

    const HEADER_COOPERADO = ['nome','cpfcnpj','telefonecelular','telefoneresidencial','pontoatendimento','endereco','cidade','uf','renda','sigla'];
    const HEADER_PRODUTO_CARTAO = ['pontoatendimento','cpfcnpj','contacartao','dataaberturacontacartao', 'produto', 'valorlimiteatribuido', 'faturamento', 'limiteaprovadofabrica'];
    const HEADER_PRODUTO_CARTAO_SEM_LIMITE = ['pontoatendimento','cpfcnpj', 'rendabruta', 'ultimarenovacaocadastral', 'contacartao', 'produto', 'situacao'];
    const HEADER_PRODUTO_CARTAO_COM_LIMITE_E_BLOQUEIO = ['pontoatendimento','cpfcnpj', 'rendabruta', 'ultimarenovacaocadastral', 'contacartao', 'produto', 'situacao', 'limiteatribuido'];
    const HEADER_PRODUTO_LIMITE_SEM_LIMITE = ['movimento', 'pontoatendimento','cpfcnpj', 'rendabruta', 'indicadorlimitecredito', 'numerocontacorrente', 'dataaberturacontacorrente', 'modalidadecontacorrente', 'categoriacontacorrente', 'situacaocontacorrente', 'diassemmovimentacao'];

    /**
     * Função validar arquivo
     *
     * Função responsável por validar os cabeçalhos dos arquivos
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file
     * @param string $tabela
     * @return bool
     * @throws Exception
     **/
    public function validarHeaderArquivo($file, string $tabela)
    {
        $header = (new HeadingRowImport)->toArray($file);

        switch($tabela){
            case TabelaProdutos::COOPERADO->value:
                $colunasAusentes = array_diff(self::HEADER_COOPERADO, $header[0][0]);
                if($colunasAusentes) throw new Exception("Não encontramos as colunas:".implode(",", $colunasAusentes), 400);
                break;
            case TabelaProdutos::CARTAO->value:
                $colunasAusentes = array_diff(self::HEADER_PRODUTO_CARTAO, $header[0][0]);
                if($colunasAusentes) throw new Exception("Não encontramos as colunas:".implode(",", $colunasAusentes), 400);
                break;
            case TabelaProdutos::COOPERADO_SEM_LIMITE->value:
                $colunasAusentes = array_diff(self::HEADER_PRODUTO_CARTAO_SEM_LIMITE, $header[0][0]);
                if($colunasAusentes) throw new Exception("Não encontramos as colunas:".implode(",", $colunasAusentes), 400);
                break;
            case TabelaProdutos::COOPERADO_COM_LIMITE_E_BLOQUEIO->value:
                $colunasAusentes = array_diff(self::HEADER_PRODUTO_CARTAO_COM_LIMITE_E_BLOQUEIO, $header[0][0]);
                if($colunasAusentes) throw new Exception("Não encontramos as colunas:".implode(",", $colunasAusentes), 400);
                break;
            case TabelaProdutos::LIMITES_COOPERADO_SEM_LIMITE->value:
                $colunasAusentes = array_diff(self::HEADER_PRODUTO_LIMITE_SEM_LIMITE, $header[0][0]);
                if($colunasAusentes) throw new Exception("Não encontramos as colunas:".implode(",", $colunasAusentes), 400);
                break;
            default:
                throw new Exception("Não encontramos uma tabela válida");
        }

        return true;
    }

    /**
     * Função processar arquivo
     *
     * Função responsável por disparar o trabalho para a fila
     *
     * @param string $tabela Tabela se refere ao produto
     * @param ?int $grupoId Referente ao grupo
     **/
    public function processarArquivo($file, string $tabela, ?int $grupoId)
    {
        if($tabela !== TabelaProdutos::COOPERADO->value){
            $produtoId = Produto::where('nome', $tabela)->first()->id;
        }

        switch($tabela){
            case TabelaProdutos::COOPERADO->value:
                (new CooperadoImport)->import($file);
                break;
            case TabelaProdutos::CARTAO->value:
                (new ProdutoCartaoImport($produtoId, $grupoId))->import($file);
                break;
            case TabelaProdutos::COOPERADO_SEM_LIMITE->value:
                (new ProdutoCooperadoSemLimiteImport($produtoId, $grupoId))->import($file);
                break;
            case TabelaProdutos::COOPERADO_COM_LIMITE_E_BLOQUEIO->value:
                (new ProdutoCooperadoComLimiteBloqueioImport($produtoId, $grupoId))->import($file);
                break;
            case TabelaProdutos::LIMITES_COOPERADO_SEM_LIMITE->value:
                (new ProdutoLimiteCooperadoSemLimiteImport($produtoId, $grupoId))->import($file);
                break;
            default:
                throw new Exception("Não encontramos uma tabela válida");
        }
    }
}
