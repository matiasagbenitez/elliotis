<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clients\EditClient;
use App\Http\Livewire\Clients\CreateClient;
use App\Http\Livewire\Clients\IndexClients;
use App\Http\Livewire\Countries\IndexCountries;
use App\Http\Livewire\Provinces\IndexProvinces;
use App\Http\Livewire\Localities\IndexLocalities;
use App\Http\Livewire\IvaConditions\IndexIvaConditions;

Route::get('/countries', IndexCountries::class)->name('admin.countries.index');
Route::get('/provinces', IndexProvinces::class)->name('admin.provinces.index');
Route::get('/localities', IndexLocalities::class)->name('admin.localities.index');

Route::get('/iva-conditions', IndexIvaConditions::class)->name('admin.iva-conditions.index');

Route::get('/clients', IndexClients::class)->name('admin.clients.index');
Route::get('/clients/create', CreateClient::class)->name('admin.clients.create');
Route::get('/clients/{client}/edit', EditClient::class)->name('admin.clients.edit');
