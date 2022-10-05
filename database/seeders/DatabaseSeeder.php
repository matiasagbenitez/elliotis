<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(IvaConditionSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(PaymentConditionsSeeder::class);
        $this->call(PaymentMethodsSeeder::class);
        $this->call(VoucherTypesSeeder::class);
        $this->call(IvaTypesSeeder::class);
        $this->call(InchSeeder::class);
        $this->call(FeetSeeder::class);
        $this->call(MeasureSeeder::class);
        $this->call(TrunkMeasureSeeder::class);
        $this->call(UnitySeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(TaskTypeSeeder::class);
    }
}
