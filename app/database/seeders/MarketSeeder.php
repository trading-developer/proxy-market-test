<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Proxy;
use Illuminate\Database\Seeder;

/**
 * Class MarketSeeder
 */
class MarketSeeder extends Seeder
{
    public function run()
    {
        $this->providers();
    }

    private function providers()
    {
        $providerCodes = [
            'Ростелеком' => 'rostel',
            'МГТС' => 'mgts',
            'Билайн' => 'beeline',
            'Yota' => 'yota',
        ];

        foreach ($providerCodes as $title => $code) {
            $provider = Provider::factory()->create([
                'title' => $title,
                'code' => $code,
            ]);

            Proxy::factory()->count(100)->create([
                'provider_id' => $provider->id
            ]);
        }

    }
}
