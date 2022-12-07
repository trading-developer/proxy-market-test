<?php

namespace Tests\Feature;

use App\Exceptions\Handler;
use App\Http\Requests\Proxy\ExportRequest;
use App\Http\Resources\ProxyResource;
use App\Models\Provider;
use App\Models\Proxy;
use Tests\TestCase;

class ProxyTest extends TestCase
{

    /**
     * @return void
     */
    public function testStoreOk()
    {
        $provider = Provider::find(3);

        $data = [
            'ip' => $this->faker->ipv4(),
            'port' => $this->faker->numberBetween(10, 65000),
            'login' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'status' => $this->faker->randomElement(Proxy::STATUSES),
            'provider_id' => $provider->id,
        ];

        $request = $this
            ->post(route('proxies.store'), $data, $this->getAuthHeaders());

        $request->assertStatus(201);

        $content = json_decode($request->getContent(), true);

        unset($data['provider_id']);

        foreach (array_keys($data) as $field) {
            $this->assertArrayHasKey($field, $content);
        }
    }

    /**
     * @return void
     */
    public function testShowOk()
    {
        $provider = Provider::find(3);

        $proxy = Proxy::factory()->create([
            'provider_id' => $provider->id,
        ]);

        $this
            ->getJson(route('proxies.show', $proxy->id), $this->getAuthHeaders())
            ->assertOk()
            ->assertJson(
                json_decode(ProxyResource::make($proxy)->toJson(), true)
            );
    }

    /**
     * @return void
     */
    public function testShow404()
    {
        $this
            ->getJson(route('proxies.show', $this->randInt()))
            ->assertStatus(404)
            ->assertJson([
                'error' => Handler::ERROR_NO_DATA_FOUND
            ]);
    }

    /**
     * @return void
     */
    public function testUpdate404()
    {
        $this
            ->putJson(route('proxies.update', $this->randInt()))
            ->assertStatus(404)
            ->assertJson([
                'error' => Handler::ERROR_NO_DATA_FOUND
            ]);
    }

    /**
     * @return void
     */
    public function testDestroy404()
    {
        $this
            ->deleteJson(route('proxies.destroy', $this->randInt()))
            ->assertStatus(404)
            ->assertJson([
                'error' => Handler::ERROR_NO_DATA_FOUND
            ]);
    }

    /**
     * @return void
     */
    public function testList()
    {
        $request = $this
            ->getJson(route('proxies.index'), $this->getAuthHeaders())
            ->assertOk();

        $content = json_decode($request->getContent(), true);

        foreach ([
                     'data',
                     'links',
                     'meta',
                 ] as $field) {
            $this->assertArrayHasKey($field, $content);
        }
        foreach ([
                     'path',
                     'per_page',
                     'to',
                     'total',
                 ] as $field) {
            $this->assertArrayHasKey($field, $content['meta']);
        }
    }

    /**
     * @return void
     */
    public function testExport()
    {
        $response = $this->post(route('proxies.export', ['format' => ExportRequest::IP_PORT_LOGIN_PASS_FORMAT]));
        $response->assertStatus(200);
    }
}
