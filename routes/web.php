<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

//use Illuminate\Auth;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/home/getpoints', 'App\Http\Controllers\HomeController@getpoints');
Route::get('/home/getpoints/local', 'App\Http\Controllers\HomeController@getpointslocal');
Route::get('/home/carregar_filtros', 'App\Http\Controllers\HomeController@carregar_filtros');
Route::get('/home/ver_ois/{id}', 'App\Http\Controllers\HomeController@ver_ois');
Route::get('/home/teste', 'App\Http\Controllers\HomeController@teste');

Route::get('/contratos/combo_servicos/{id}', 'App\Http\Controllers\ContratoController@get_comboservicos');
Route::get('/ois/combo_areas/{id}', 'App\Http\Controllers\OisController@get_comboareas');
Route::get('/ois/combo_servicos/{id}', 'App\Http\Controllers\OisController@get_comboservicos');

Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('app/public/' . $filename); 
    if (!File::exists($path)) {
        abort(404);
    } 
    $file = File::get($path);
    $type = File::mimeType($path); 
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type); 
    return $response;
});

Route::group(['middleware' => 'acesso'], function () {

	Route::get('anexos', 'App\Http\Controllers\AnexoController@show');
	Route::get('anexos/delete/{id}', 'App\Http\Controllers\AnexoController@destroy');
	Route::post('anexos', 'App\Http\Controllers\AnexoController@store');


	Route::get('/usuarios', 'App\Http\Controllers\UserController@index')->name('usuarios');
	Route::get('/usuarios/cadastro', 'App\Http\Controllers\UserController@create');
	Route::post('/usuarios/cadastro', 'App\Http\Controllers\UserController@store');
	Route::get('/usuarios/cadastro/{id}', 'App\Http\Controllers\UserController@edit');
	Route::get('/usuarios/delete/{id}', 'App\Http\Controllers\UserController@destroy_user');
	Route::get('/usuarios/vinculos/{id}', 'App\Http\Controllers\UserController@getVinculo');
	Route::get('/usuarios/vinculos/delete/{id}', 'App\Http\Controllers\UserController@getVinculoDelete');
	Route::post('/usuarios/vinculos', 'App\Http\Controllers\UserController@postVinculo');

	Route::get('/clientes', 'App\Http\Controllers\ClienteController@index');
	Route::get('/clientes/cadastro', 'App\Http\Controllers\ClienteController@create');
	Route::get('/clientes/cadastro/{id}', 'App\Http\Controllers\ClienteController@edit');
	Route::get('/clientes/delete/{id}', 'App\Http\Controllers\ClienteController@destroy');
	Route::get('/clientes/ver_contratos/{id}', 'App\Http\Controllers\ClienteController@getVerContratos');
	Route::post('/clientes/cadastro', 'App\Http\Controllers\ClienteController@store');
 	
	Route::get('/contratos', 'App\Http\Controllers\ContratoController@index')->name('contratos');
	Route::get('/contratos/cadastro', 'App\Http\Controllers\ContratoController@create');
	Route::post('/contratos/cadastro', 'App\Http\Controllers\ContratoController@store');
	Route::get('/contratos/cadastro/{id}', 'App\Http\Controllers\ContratoController@edit');
	Route::get('/contratos/delete/{id}', 'App\Http\Controllers\ContratoController@destroy_contrato');
	Route::get('/contratos/ver_aditivos/{id}', 'App\Http\Controllers\ContratoController@getVerAditivos');
	Route::get('/contratos/ver_servicos/{id}', 'App\Http\Controllers\ContratoController@getVerServicos');


	// Route::get('/contratos/anexos/{id}', 'App\Http\Controllers\ContratoController@getAnexo');
	// Route::get('/contratos/anexos/delete/{id}', 'App\Http\Controllers\ContratoController@getAnexoDelete');
	// Route::post('/contratos/anexos', 'App\Http\Controllers\ContratoController@postAnexo');

	Route::get('/contratos/servicos/{id}', 'App\Http\Controllers\ContratoController@getServico');
	Route::get('/contratos/servicos/delete/{id}', 'App\Http\Controllers\ContratoController@getServicoDelete');
	Route::post('/contratos/servicos', 'App\Http\Controllers\ContratoController@postServico');

	Route::get('/contratos/aditivos/{id}', 'App\Http\Controllers\ContratoController@getAditivo');
	Route::post('/contratos/aditivos', 'App\Http\Controllers\ContratoController@postAditivo');
	Route::get('/contratos/aditivos/delete/{id}', 'App\Http\Controllers\ContratoController@getAditivoDelete');
	Route::get('/contratos/aditivos/edit/{id}', 'App\Http\Controllers\ContratoController@editaditivo');

	Route::get('/locals', 'App\Http\Controllers\LocalController@index')->name('locals');;
	Route::get('/locals/cadastro', 'App\Http\Controllers\LocalController@create');
	Route::post('/locals/cadastro', 'App\Http\Controllers\LocalController@store');
	Route::get('/locals/cadastro/{id}', 'App\Http\Controllers\LocalController@edit');
	Route::get('/locals/geo/{id}', 'App\Http\Controllers\LocalController@geo');
	Route::get('/locals/delete/{id}', 'App\Http\Controllers\LocalController@destroy_local');

	Route::get('/areas', 'App\Http\Controllers\AreaController@index')->name('areas');;
	Route::get('/areas/cadastro', 'App\Http\Controllers\AreaController@create');
	Route::post('/areas/cadastro', 'App\Http\Controllers\AreaController@store');
	Route::get('/areas/cadastro/{id}', 'App\Http\Controllers\AreaController@edit');
	Route::get('/areas/delete/{id}', 'App\Http\Controllers\AreaController@destroy');

	Route::get('/ois', 'App\Http\Controllers\OisController@index')->name('ois');;
	Route::get('/ois/cadastro', 'App\Http\Controllers\OisController@create');
	Route::post('/ois/cadastro', 'App\Http\Controllers\OisController@store');
	Route::get('/ois/getcontratos/{id}', 'App\Http\Controllers\OisController@getContratos');
	Route::get('/ois/getservicos/{id}', 'App\Http\Controllers\OisController@getservicos');
	Route::get('/ois/gettipocontrato/{id}', 'App\Http\Controllers\OisController@gettipocontrato');
	Route::get('/ois/cadastro/{id}', 'App\Http\Controllers\OisController@edit');
	Route::get('/ois/delete/{id}', 'App\Http\Controllers\OisController@destroy_ois');


	Route::post('/ois/andamento/cadastro', 'App\Http\Controllers\OisController@store_andamento');
	Route::get('/ois/andamento/{id}', 'App\Http\Controllers\OisController@getandamento');
	Route::get('/ois/andamento/edit/{id}', 'App\Http\Controllers\OisController@editandamento');
	Route::get('/ois/andamento/delete/{id}', 'App\Http\Controllers\OisController@destroy_ois_andamento');
	Route::get('/ois/ver_fotos/{id}', 'App\Http\Controllers\OisController@getVerFotos');
	Route::get('/ois/ver_fotos_tb/{id}', 'App\Http\Controllers\OisController@getVerFotosTb');
	Route::get('/ois/getcomboservico/{id}', 'App\Http\Controllers\OisController@getcomboservico');
	
	// Route::get('/ois/anexos/{id}', 'App\Http\Controllers\OisController@getAnexo');
	// Route::get('/ois/anexos/delete/{id}', 'App\Http\Controllers\OisController@getAnexoDelete');
	// Route::post('/ois/anexos', 'App\Http\Controllers\OisController@postAnexo');


	Route::get('/servico_tipos', 'App\Http\Controllers\Servico_tipoController@index')->name('servico_tipos');;
	Route::get('/servico_tipos/cadastro', 'App\Http\Controllers\Servico_tipoController@create');
	Route::post('/servico_tipos/cadastro', 'App\Http\Controllers\Servico_tipoController@store');
	Route::get('/servico_tipos/cadastro/{id}', 'App\Http\Controllers\Servico_tipoController@edit');
	Route::get('/servico_tipos/delete/{id}', 'App\Http\Controllers\Servico_tipoController@destroy');

	Route::get('/regiaos', 'App\Http\Controllers\RegiaoController@index')->name('regiaos');
	Route::get('/regiaos/cadastro', 'App\Http\Controllers\RegiaoController@create');
	Route::post('/regiaos/cadastro', 'App\Http\Controllers\RegiaoController@store');
	Route::get('/regiaos/cadastro/{id}', 'App\Http\Controllers\RegiaoController@edit');
	Route::get('/regiaos/delete/{id}', 'App\Http\Controllers\RegiaoController@destroy');

	Route::get('/regiaos/vinculos/{id}', 'App\Http\Controllers\RegiaoController@getVinculo');
	Route::get('/regiaos/vinculos/delete/{id}', 'App\Http\Controllers\RegiaoController@getVinculoDelete');
	Route::post('/regiaos/vinculos', 'App\Http\Controllers\RegiaoController@postVinculo');
	Route::get('/regiaos/tabela', 'App\Http\Controllers\RegiaoController@tabelateste');

	Route::get('/gerenciadoras', 'App\Http\Controllers\GerenciadoraController@index')->name('gerenciadoras');;
	Route::get('/gerenciadoras/cadastro', 'App\Http\Controllers\GerenciadoraController@create');
	Route::post('/gerenciadoras/cadastro', 'App\Http\Controllers\GerenciadoraController@store');
	Route::get('/gerenciadoras/cadastro/{id}', 'App\Http\Controllers\GerenciadoraController@edit');
	Route::get('/gerenciadoras/delete/{id}', 'App\Http\Controllers\GerenciadoraController@destroy');

	Route::get('/gerenciadoras/vinculos/{id}', 'App\Http\Controllers\GerenciadoraController@getVinculo');
	Route::get('/gerenciadoras/vinculos/delete/{id}', 'App\Http\Controllers\GerenciadoraController@getVinculoDelete');
	Route::post('/gerenciadoras/vinculos', 'App\Http\Controllers\GerenciadoraController@postVinculo');

	Route::get('/tipo_contratos', 'App\Http\Controllers\TipoContratoController@index')->name('tipo_contrato');;
	Route::get('/tipo_contratos/cadastro', 'App\Http\Controllers\TipoContratoController@create');
	Route::post('/tipo_contratos/cadastro', 'App\Http\Controllers\TipoContratoController@store');
	Route::get('/tipo_contratos/cadastro/{id}', 'App\Http\Controllers\TipoContratoController@edit');
	Route::get('/tipo_contratos/delete/{id}', 'App\Http\Controllers\TipoContratoController@destroy');

	// Route::get('/tipo_contratos/anexos/{id}', 'App\Http\Controllers\TipoContratoController@getAnexo');
	// Route::get('/tipo_contratos/anexos/delete/{id}', 'App\Http\Controllers\TipoContratoController@getAnexoDelete');
	// Route::post('/tipo_contratos/anexos', 'App\Http\Controllers\TipoContratoController@postAnexo');
});
Route::group(['middleware' => 'auth'], function () {
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

