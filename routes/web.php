<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

/**
 * @description Mostra todos users
 */
Route::get('/users','UsersGruposController@allUsers')->name('user')->middleware('auth','grupo');


/**
 * @description Edita parametro grupo dos User
 */
Route::get('/users/{id}','UsersGruposController@edit')->name('user')->middleware('auth','grupo');

/**
 * @description Grava as alterações do User na base de dados
 */
Route::patch('/users/{id}','UsersGruposController@update')->name('user')->middleware('auth','grupo');


/**
 * @description Pesquisa por Users
 */
Route::post('/searchUsers','SearchController@searchUsers')->name('user')->middleware('auth','grupo');



/**
 * @description Mostra o ecra inicial
 */
Route::get('/', 'HomeController@index')->name('/')->middleware('auth','grupo');


/**
 * @description Mostra a pagina about
 */
Route::get('/about','aboutController@index')->name('about')->middleware('auth','grupo');



/**
 * @index Mostra todos os items e parte dos seus atributos~
 * @show Mostra os atributos de um item
 * @create Cria um item
 * @store Grava o item criado na base de dados
 * @edit Edita um item
 * @update Grava as alterações do item na base de dados
 * @destroy Remove um item
 */
Route::resource('items', 'ItemsController')->middleware('auth','grupo');

/**
 * @description Pesquisa de items e kits
 */
//Route::post('/searchItemsKits','SearchController@searchItemsKits')->name('item')->middleware('auth','grupo');
Route::post('/searchItemsAndKits','SearchController@searchItemsAndKits')->name('item')->middleware('auth','grupo');

/**
 * @description Pesquisa items dentro de um kit
 */
Route::post('/searchItemsInKits/{id}','SearchController@searchItemsInKits')->name('item')->middleware('auth','grupo');

/**
 * @description Pesquisa items fora de um kit
 */
Route::post('/searchItemsOutKits/{id}','SearchController@searchItemsOutKits')->name('item')->middleware('auth','grupo');

/**
 * @index Mostra todos os Kit e parte dos seus atributos
 * @show Mostra os atributos de um kit
 * @create Cria um Kit
 * @store Grava o Kit criado na base de dados
 * @edit Edita um Kit
 * @update Grava as alterações do Kit na base de dados
 * @destroy Remove um Kit
 */
Route::resource('kits', 'KitsController')->middleware('auth','grupo');

/**
 * @description Insere um item num kit
 */
Route::patch('/insertItemKit/{item_id}/{kit_id}','KitsController@insertItemKit')->name('kit')->middleware('auth','grupo');

/**
 * @description Remove item do kit
 */
Route::patch('/removeItemKit/{item_id}/{kit_id}','KitsController@removeItemKit')->name('kit')->middleware('auth','grupo');

/**
 * @description Mostra lista de items dentro e fora de um kit
 */
Route::get('/addItems/{id}','KitsController@addKit')->name('kit')->middleware('auth','grupo');



/**
 * @index Mostra todas as categorias
 * @show Mostra uma categoria e os items dentro dela
 * @create Cria uma categoria
 * @store Grava a categoria na base de dados
 * @edit Edita a categoria
 * @update Grava as alterações das categorias na base de dados
 * @destroy Remove a categoria
 */
Route::resource('categorias', 'CategoriasController')->middleware('auth','grupo');

/**
 * @description Pesquisa categorias
 */
Route::post('/searchCategorias','SearchController@searchCategorias')->name('categorias')->middleware('auth','grupo');



/**
 * @index Mostra todas as reservas
 * @show Mostra uma reserva e os seus parametros
 * @create Cria as Reservas
 * @store Grava as reservas na base de dados
 * @edit Edita a Reserva
 * @update Grava as alterações da Reserva na base de dados
 * @destroy Remove a Reserva
 */
Route::resource('reservas', 'ReservasController')->middleware('auth','grupo');

/**
 * @description Pesquisa por Reservas
 */
Route::post('/searchReservas','SearchController@searchReservas')->name('reserva')->middleware('auth','grupo');


/**
 * @description Mostra todas as reservas em Atraso
 */
Route::get('/reservasAtraso', 'ReservasAtrasoController@index')->middleware('auth','grupo');

/**
 * @description Mostra todas as reservas pendentes
 */
Route::get('/reservasPendentes', 'ReservasPendentesController@index')->middleware('auth','grupo');

/**
 * @description Mostra todas as reservas Concluidas
 */
Route::get('/reservasConcluidas','ReservasConcluidasController@index')->middleware('auth','grupo');

/**
 * @description Mostra todas as reservas Rejeitadas
 */
Route::get('/reservasRejeitadas','ReservasRejeitadasController@index')->middleware('auth','grupo');

/**
 * @description Mostra todas as reservas a decorrer
 */
Route::get('/reservasDecorrer','ReservasDecorrerController@index')->middleware('auth','grupo');


/**
 * @description Define a reserva como aceite
 */
Route::patch('/acceptReserva/{id}','ReservasController@acceptReserva')->middleware('auth','grupo');

/**
 * @description Define a reserva como Rejeitada
 */
Route::patch('/refuseReserva/{id}','ReservasController@refuseReserva')->middleware('auth','grupo');

/**
 * @description Define a reserva como concluida
 */
Route::patch('/isConcluida/{id}','ReservasController@isConcluida')->name('reserva')->middleware('auth','grupo');



/**
 * @index Mostra todos os grupos
 * @show Mostra um grupo e os utilizadores dentro deste
 * @create Cria um grupo
 * @store Grava o grupo na base de dados
 * @edit Edita o Grupo
 * @update Grava as alterações do grupo na base de dados
 * @destroy Remove o grupo
 */
Route::resource('grupos', 'GruposController')->middleware('auth','grupo');

/**
 * @description Pesquisa por grupos
 */
Route::post('/searchGrupos','SearchController@searchGrupos')->name('grupo')->middleware('auth','grupo');


/**
 * @description Pesquisa por users dentro de um grupo
 */
Route::post('/searchUsersInGrupo/{id}','SearchController@searchInUsers')->name('user')->middleware('auth','grupo');

/**
 * @description Pesquisa por users fora de um grupo
 */
Route::post('/searchUsersOutGrupo/{id}','SearchController@searchOutUsers')->name('user')->middleware('auth','grupo');

/**
 * @description Insere user num Grupo
 */
Route::post('/insertGrupo/{user_id}/{id}','GruposController@insertUser')->name('grupo')->middleware('auth','grupo');

/**
 * @description Remove user de um Grupo 
 */
Route::post('/removeGrupo/{user_id}/{id}','GruposController@removeUser')->name('grupo')->middleware('auth','grupo');


/**
 * @description Mostra todos os items e kits no carrinho
 */
Route::get('/carrinho', 'CarrinhoController@index')->name('carrinho')->middleware('auth','grupo');

/**
 * @description Remove o item ou kit do carrinho
 */
Route::patch('/removeItemCarrinho/{id}', 'CarrinhoController@removeItem')->name('carrinho')->middleware('auth','grupo');

/**
 * @description Insere o item ou kit no carrinho
 */
Route::patch('/insertItemCarrinho/{id}', 'CarrinhoController@store')->name('carrinho')->middleware('auth','grupo');

/**
 * @description Remove item do carrinho
 */
Route::delete('/removeItemFromCarrinho/{id}','CarrinhoController@destroyLinhaItem')->name('carrinho')->middleware('auth','grupo');

/**
 * @description Remove kit do carrinho
 */
Route::delete('/removeKitFromCarrinho/{id}','CarrinhoController@destroyLinhaKit')->name('carrinho')->middleware('auth','grupo');


/**
 * @description Faz o download do pdf das reservas
 */
Route::post('/pdf_download/{id}', 'ReservasController@downloadPdf')->name('reserva')->middleware('auth','grupo');






