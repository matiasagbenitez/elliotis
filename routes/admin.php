<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clients\EditClient;
use App\Http\Livewire\Clients\CreateClient;
use App\Http\Livewire\Clients\IndexClients;
use App\Http\Livewire\IvaTypes\IndexIvaTypes;
use App\Http\Livewire\Measures\IndexMeasures;
use App\Http\Livewire\Suppliers\EditSupplier;
use App\Http\Livewire\Countries\IndexCountries;
use App\Http\Livewire\Provinces\IndexProvinces;
use App\Http\Livewire\Suppliers\CreateSupplier;
use App\Http\Livewire\Suppliers\IndexSuppliers;
use App\Http\Livewire\Localities\IndexLocalities;
use App\Http\Livewire\IvaConditions\IndexIvaConditions;
use App\Http\Livewire\PucharseParameters\IndexPucharseParameters;

Route::get('/countries', IndexCountries::class)->name('admin.countries.index');
Route::get('/provinces', IndexProvinces::class)->name('admin.provinces.index');
Route::get('/localities', IndexLocalities::class)->name('admin.localities.index');

Route::get('/iva-conditions', IndexIvaConditions::class)->name('admin.iva-conditions.index');

Route::get('/clients', IndexClients::class)->name('admin.clients.index');
Route::get('/clients/create', CreateClient::class)->name('admin.clients.create');
Route::get('/clients/{client}/edit', EditClient::class)->name('admin.clients.edit');

Route::get('/suppliers', IndexSuppliers::class)->name('admin.suppliers.index');
Route::get('/suppliers/create', CreateSupplier::class)->name('admin.suppliers.create');
Route::get('/suppliers/{supplier}/edit', EditSupplier::class)->name('admin.suppliers.edit');

Route::get('/pucharse-parameters', IndexPucharseParameters::class)->name('admin.pucharse-parameters.index');

Route::get('/iva-types', IndexIvaTypes::class)->name('admin.iva-types.index');

Route::get('/measures', IndexMeasures::class)->name('admin.measures.index');
