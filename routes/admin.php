<?php

use App\Http\Livewire\Countries\IndexCountries;
use App\Http\Livewire\IvaConditions\IndexIvaConditions;
use App\Http\Livewire\Provinces\IndexProvinces;
use App\Http\Livewire\Localities\IndexLocalities;
use Illuminate\Support\Facades\Route;

Route::get('/countries', IndexCountries::class)->name('admin.countries.index');
Route::get('/provinces', IndexProvinces::class)->name('admin.provinces.index');
Route::get('/localities', IndexLocalities::class)->name('admin.localities.index');
Route::get('/iva-conditions', IndexIvaConditions::class)->name('admin.iva-conditions.index');
