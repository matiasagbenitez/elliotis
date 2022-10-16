<?php

namespace Database\Seeders;

use App\Models\IvaCondition;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IvaConditionSeeder extends Seeder
{
    public function run()
    {
        $ivaConditions = [
            [
                'name' => 'IVA Responsable Inscripto',
                'discriminate' => false,
            ],
            [
                'name' => 'IVA Sujeto Exento',
                'discriminate' => true,
            ],
            [
                'name' => 'Monotributista',
                'discriminate' => true,
            ],
            [
                'name' => 'Consumidor Final',
                'discriminate' => true,
            ]
        ];

        foreach ($ivaConditions as $ivaCondition) {
            IvaCondition::create($ivaCondition);
        }
    }
}
