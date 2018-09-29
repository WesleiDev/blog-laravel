<?php
/**
 * Created by PhpStorm.
 * User: José Eduardo
 * Date: 09/11/2017
 * Time: 10:53
 */

namespace App;


use App\Models\Empresa;
use App\Models\LogUsuario;
use App\Models\UserTenant;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use JWTAuth;

class Utilitarios
{
    static function formatReal($value)
    {
        $aux = 0;
        $value = ($value === '') ? 0 : $value;
        if ($value ) {
            if (strpos($value, ',')){
                $aux = str_replace(".", "", $value);
                $aux = str_replace(",", ".", $aux);
            }else{
                $aux = $value;
            }
            $aux = str_replace("%", "", $aux);
            $value = str_replace("-", "", $aux);
        }

        return number_format($value,2,'.','');
    }

    static function getFormatReal($value){
        return number_format($value, 2, ',', '.');
    }

    static function formatPercent($value)
    {
        $aux = 0;
        if ($value) {
            $aux = str_replace("%", "", $value);
            $aux = str_replace(",", ".", $aux);
        }
        return $aux;
    }

    static function formatCheckbox($value)
    {
        $aux = false;
        if ($value) {
            $aux = str_replace("on", true, $value);
        }
        return $aux;
    }

    static function formatDataCarbon($value)
    {
        $data = null;
        $hora = 0;
        $min = 0;

        if (isset($value) && (!$value instanceof Carbon)) {
            $formatodata = substr($value, 2, 1);
            if ($formatodata == '-' || $formatodata == '/') {
                $dia = substr($value, 0, 2);
                $mes = substr($value, 3, 2);
                $ano = substr($value, 6, 4);
            } else {
                $dia = substr($value, 8, 2);
                $mes = substr($value, 5, 2);
                $ano = substr($value, 0, 4);
            }
            $datahora = explode(' ', $value);
            if(isset($datahora[1])){
                $hora = substr($datahora[1], 0,2);
                $min = substr($datahora[1], 3,2);
            }

            $data = Carbon::create($ano, $mes, $dia, $hora, $min);
        } else if ($value instanceof Carbon) {
            $data = $value;
        }

        return $data;
    }

    static function formatGetData($value)
    {
        $data = null;
        if (isset($value)) {
            $data = strtotime($value);
            $data = date('d/m/Y', $data);
        }
        return $data;
    }

    static function removeCaracter($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    static function getPivot($model)
    {
        $array = [];
        foreach ($model as $registro) {
            array_push($array, $registro->pivot);
        }
        return $array;
    }

    /** * Função para formatar os dados para retornar em uma requisição HTTP *
     * @access public
     * @param array $data
     * @param Boolean $result
     * @param String $nomedata = 'data'
     * @return \Response
     */
    static function formatResponse($data, $result, $nomedata = 'data')
    {
       if ($data == '[]' || empty($data)) {
           return response()->json([$nomedata => 'Dados não encontrado', 'result' => $result], 200);
       } else {

           try{
               //Se não for um array
               if (!is_array($data)){
                   $count = 1;
               }else{
                   $count = count($data);
               }

           }catch (\Exception $e){
               try{
                   if(is_string($data)){
                       $count = 1;
                   }else{
                       $count = $data->count();
                   }

               }catch (\Exception $e){
                   $count = 1;
               }

           }


           return response()->json([$nomedata => $data, 'count' => $count, 'result' => $result], 200);
       }
    }

    /** * Função para salvar os registros da API no banco de dados
     * @access public
     * @param $model \Illuminate\Database\Eloquent\Model
     * @param mixed $data
     * @return Model */
    static function salvarModel($model, $data){
        /** @var  \Illuminate\Database\Eloquent\Model $model */
        $model;
        $data['id'] = isset($data['id'])?$data['id']:0;
        try {
            DB::connection()->getPdo()->beginTransaction();
            $res = $model::find($data['id']);

            if($res){
                $res->update($data);
                $res['created'] = false;
            }else{
                $res =  $model::create($data);
                $res['created'] = true;

            }
            DB::connection()->getPdo()->commit();
        }catch (\Exception $e){
            throw new \Exception('Verifique os parâmetros informados '.$e->getMessage());
//            return self::getMsgErroSalvar();
        }

        return $res;
    }
    /** * Função para excluir os registros da API no banco de dados
     * @access public
     * @param $model \Illuminate\Database\Eloquent\Model
     * @param Integer id
     * @return Model
     * @throws \Exception
     */
    static function deleteModel($model, $id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $res = $model::find($id);
            if($res){
                $res->delete();
            }else{
                throw new \Exception('Verifique se o registro não esta sendo utilizado em outro cadastro!');
            }
            DB::connection()->getPdo()->commit();
        }catch(\Exception $e){
            throw new \Exception('Verifique os parâmetros informados '.$e->getMessage());
        }
        return $res;
    }

    public static function getBtnAction($botoes = []){
        $return = '';
//        ['tipo'=> 'editar', 'nome'=>'Editar', 'class' => '', 'url' => ''];
        //TIPO=> excluir, editar, outros, print, email


        for ($i = 0; $i < count($botoes); $i++ ){
            $icone = '';
            if ($botoes[$i]['tipo'] == 'excluir'){
                $icone = $botoes[$i]['class'];
                $return = $return . '<a data-url="'.$botoes[$i]['url'].'"
                data-titulo="Exclusão"
                data-msg="Deseja realmente excluir o registro selecionado?"
                title="'.$botoes[$i]['nome'].'"
                class="confirm btn-table btn btn-icon '.($botoes[$i]['disabled']==false?'disabled':'').'"
                href="void:javascript(0)"
                data-id="'.$botoes[$i]['url'].'"><i class="'.$icone.'"></i></a>';
            }else if($botoes[$i]['tipo'] == 'editar'){
                $icone = $botoes[$i]['class'];
                $return = $return . '<a href="'.$botoes[$i]['url'].'" 
                data-titulo="'.$botoes[$i]['nome'].'" 
                class="btn-table btn btn-icon '.($botoes[$i]['disabled']==false?'disabled':'').'"
                title="Editar" style="padding:1.5px"><i class="'.$icone.'"></i></a>';
            }else if($botoes[$i]['tipo'] == 'outros'){
                $icone = $botoes[$i]['class'];
                $return = $return . '<a href="'.$botoes[$i]['url'].'" 
                data-titulo="'.$botoes[$i]['nome'].'" 
                class="btn-table btn btn-icon '.($botoes[$i]['disabled']==false?'disabled':'').'"
                title="'.$botoes[$i]['nome'].'" style="padding:1.5px"
                ><i class="'.$icone.'"></i></a>';
            }else if($botoes[$i]['tipo'] == 'print'){
                $icone = $botoes[$i]['class'];
                $return = $return . '<a href="'.$botoes[$i]['url'].'" 
                data-titulo="'.$botoes[$i]['nome'].'" 
                class="btn-table btn btn-icon '.($botoes[$i]['disabled']==false?'disabled':'').'"
                title="'.$botoes[$i]['nome'].'" style="padding:1.5px" target="_blank"><i class="'.$icone.'"></i></a>';
            }else if($botoes[$i]['tipo'] == 'email'){
                $icone = $botoes[$i]['class'];
                $return = $return . '<a href="#" data-titulo="'.$botoes[$i]['nome'].'"
                data-url="'.$botoes[$i]['url'].'" 
                class="btn-table btn btn-icon btn-enviar-email '.($botoes[$i]['disabled']==false?'disabled':'').'"
                title="'.$botoes[$i]['nome'].'" style="padding:1.5px"><i class="'.$icone.'"></i></a>';
            }

        }

        return $return;
    }
    /** * Função para verificar a integridade referencial do registro
     * @access public
     * @param $e \Exception
     * @return void */
    static function isQueryException($e){
        if($e instanceof QueryException){
            $trace = $e->getTrace();
            throw new QueryException($trace[0]['args'][0], $trace[0]['args'][1], $e->getPrevious());
        }
    }

    static function isApi(){
//        $user = JWTAuth::parseToken()->authenticate();
        $user = Auth::user();
        if($user->username == 'API_'.$user->empresa->subdominio){
            return true;
        }
        return false;
    }

    /** * Função para savar um log do sistema
     * @access public
     * @param String $tabela    - Tabela que foi feita a ação
     * @param array $alteracoes- Quais foram as alterações
     * @param String $nomeregistro - Nome do registro que está sendo alterado
     * @param String $tipo ['INCLUSAO', 'ALTERACAO', 'EXCLUSAO', 'LOGIN', 'LOGOUT', 'ERRO', 'SINCRONIZACAO'] - Tipo da alteração
     * @return void */
    static function saveLog($tabela, $alteracoes, $tipo, $nomeregistro){
        $user = Auth::user();
        $log = '';
        $tipolog = ['INCLUSAO', 'ALTERACAO', 'EXCLUSAO', 'LOGIN', 'LOGOUT', 'ERRO', 'SINCRONIZACAO'];
        try{
            if(!in_array($tipo ,$tipolog)){
                throw new \Exception('Tipo de log inexistente');
            }
            if(is_array($alteracoes)){
                foreach ($alteracoes as $key => $alteracao){
                    $log = $log.$key.': "'.$alteracao.'"| ';
                }
            }else{
                $log = $alteracoes;
            }
            $data = [
                'tabela' => $tabela,
                'log' => 'Registro: '.$nomeregistro.' | '.$log,
                'tipo' => $tipo,
                'user_tenant_id' => $user->id,
                'ip' => \Request::ip()
            ];

            if(Utilitarios::isApi()){
                $data['empresa_id'] = $user->empresa_id;
                $data['user_tenant_id'] = null;
            }

            LogUsuario::create($data);
        }catch(\Exception $exception){
            \Session::flash('mensagem', ['msg'=>'Erro'.$exception->getMessage(), 'status'=>'erro']);
        }
    }

    static function rotasApi(){
        $urlapi = config('extra.url_api');

        return [
            'auth'                          =>
            [
                'url'       => $urlapi.'/auth',
                'method'    => 'POST'
            ],
            'pessoa_salvar_atualizar'       =>
                [
                'url'       => $urlapi.'/v1/pessoa',
                'method'    => 'POST'
                ],
            'pessoa_deletar'                =>
            [
                'url'       => $urlapi.'/v1/pessoa',
                'method'    => 'DELETE'
            ],
            'user_tenant_salvar_atualizar'  =>
            [
                'url'       => $urlapi.'/v1/usuario',
                'method'    => 'POST'
            ],
            'user_tenant_deletar'           =>
            [
                'url'       => $urlapi.'/v1/usuario',
                'method'    => 'DELETE'
            ],
            'endereco_entrega_salvar'       =>
            [
                'url'       => $urlapi.'/v1/pessoa/enderecoentrega',
                'method'    => 'POST'
            ],
            'endereco_entrega_deletar'      =>
            [
                'url'       => $urlapi.'/v1/pessoa/enderecoentrega',
                'method'    => 'DELETE'
            ],
            'forma_cob_salvar_atualizar'    =>
            [
                'url'       => $urlapi.'/v1/formacobranca',
                'method'    => 'POST'
            ],
            'forma_cob_deletar'             =>
            [
                'url'       => $urlapi.'/v1/formacobranca',
                'method'    => 'DELETE'
            ],
            'produto_salvar_atualizar'      =>
            [
                'url'       => $urlapi.'/v1/produto',
                'method'    => 'POST'

            ],
            'produto_deletar'      =>
                [
                    'url'       => $urlapi.'/v1/produto',
                    'method'    => 'DELETE'

                ]
        ];
    }

    static function sendApiMaster($url, $data){
        try{
            $client = new Client();
            $rota = self::rotasApi()[$url];
            $headers =
                [
                    'Authorization' => 'Bearer '.self::autenticaUsuario(),
                    'Content-Type'  => 'application/json'
                ];

            if($rota['method'] == 'POST'){
                $request = $client->request($rota['method'], $rota['url'], [
                    'headers' => $headers,
                    'json' => $data
                ]);
            }else if($rota['method'] == 'DELETE'){
                $request = $client->request($rota['method'], $rota['url'].'/'.$data,
                    [
                        'headers' => $headers
                    ]);
            }else{
                throw new \Exception(["Método não previsto no vetor de rotas"], 500);
            }

            return json_decode($request->getBody());
        }catch(\Exception $e){
            throw new \Exception($e->getMessage(), 500);
        }
    }



    static function autenticaUsuario(){
        try{
            if(!Cache::has('token')){
                $auth = self::requestToken();
                Cache::put('token', $auth->token, $auth->expires_in);
                return $auth->token;
            }else{
                return Cache::get('token');
            }
        }catch(\Exception $e){
            throw new \Exception($e->getMessage(), 500);
        }
    }

    static function requestToken(){
        try{
            $userApi = Auth::user();
            $client = new Client();
            $rota = self::rotasApi()['auth'];

            $request = $client->request($rota['method'], $rota['url'], [
                'json' => [
                    'username'  => $userApi->username,
                    'secret'    => $userApi->secret,
                    'codapp'    => $userApi->codapp,
                    'is_api'    => true
                ]
            ]);
            return json_decode($request->getBody());
        }catch(\Exception $e){
            throw new \Exception('Falha ao autenticar usuário '.$e->getMessage(), 500);
        }
    }
}