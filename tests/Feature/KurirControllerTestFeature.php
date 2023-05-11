<?php

namespace Tests\Feature;

use App\Models\Kurir;
use App\Http\Controllers\KurirController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class KurirControllerTestFeature extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFeatureIndex()
    {
        // Membuat data kurir menggunakan factory
        $kurir = Kurir::factory()->create();

        // Memanggil method index pada KurirController
        $response = $this->get('/api/v1/kurirs');

        // Memastikan response status 200 dan data yang diterima sesuai dengan data yang dibuat menggunakan factory
        $response->assertStatus(200)->assertJson([
            'data' => [
                [
                    'name' => $kurir->name,
                    'address' => $kurir->address,
                    'phone' => $kurir->phone,
                    'action' => $kurir->action,
                ],
            ],
        ]);
    }

    public function testFeatureStore()
    {
        // Data kurir baru yang akan disimpan
        $data = [
            'name' => 'Joni',
            'address' => 'Jl. Raya No. 123',
            'phone' => '081234567890',
            'action' => 'Success',
        ];

        // Memanggil method store pada KurirController dengan request yang berisi data kurir baru
        $response = $this->post('/api/v1/kurir', $data);

        // Memastikan response status 201 dan pesan serta data yang diterima sesuai dengan data yang dikirimkan
        $response->assertStatus(201)->assertJson([
            'message' => 'Add Data Kurir Success',
            'data' => $data,
        ]);
    }

    public function testFeatureShow()
    {
        // Membuat data kurir menggunakan factory
        $kurir = Kurir::factory()->create();

        // Memanggil method show pada KurirController dengan id kurir yang telah dibuat menggunakan factory
        $response = $this->get('/api/v1/kurir/' . $kurir->id);

        // Memastikan response status 200 dan data yang diterima sesuai dengan data yang dibuat menggunakan factory
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Get Kurir with ID: ' . $kurir->id . ' Success',
                'data' => [
                    'name' => $kurir->name,
                    'address' => $kurir->address,
                    'phone' => $kurir->phone,
                    'action' => $kurir->action,
                ],
            ]);
    }

    public function testFeatureUpdate()
    {
        // Membuat data kurir menggunakan factory
        $kurir = Kurir::factory()->create();

        // Data kurir yang akan diupdate
        $data = [
            'name' => 'Joni',
            'address' => 'Jl. Baru No. 123',
            'phone' => '081234567891',
            'action' => 'Success',
        ];

        // Memanggil method update pada KurirController dengan request yang berisi data kurir yang akan diupdate
        $response = $this->patch('/api/v1/kurir/' . $kurir->id, $data);

        // Memastikan response status 200 dan pesan serta data yang diterima sesuai dengan data yang diupdate
        $response->assertStatus(200)->assertJson([
            'message' => 'Update Data Kurir Success',
            'data' => $data,
        ]);
    }

    public function testFeatureDestroy()
    {
        // Membuat data kurir menggunakan factory
        $kurir = Kurir::factory()->create();

        // Memanggil method destroy pada KurirController dengan id kurir yang telah dibuat menggunakan factory
        $response = $this->delete('/api/v1/kurir/' . $kurir->id);

        // Memastikan response status 200 dan pesan yang diterima sesuai dengan data yang dihapus
        $response->assertStatus(200)->assertJson([
            'message' => 'Delete Kurir with ID: ' . $kurir->id . ' Success',
        ]);
    }
}
