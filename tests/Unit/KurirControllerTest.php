<?php

namespace Tests\Unit;

use App\Http\Controllers\KurirController;
use App\Models\Kurir;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;

class KurirControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test untuk method index.
     *
     * Method ini bertujuan untuk mengetes apakah halaman /kurirs berhasil ditampilkan dengan benar.
     *
     * @return void
     */
    public function testIndex()
    {
        // Membuat data kurir dengan factory
        $kurir = Kurir::factory()->create([
            'name' => 'Kurir1',
            'address' => 'Jl. Sudirman',
            'phone' => '08123456789',
            'action' => 'Success',
        ]);

        // Melakukan HTTP request GET ke halaman /kurirs
        $response = $this->get('/kurirs');

        // Assert HTTP response status 200 (OK) dan format JSON yang sesuai dengan expected data
        $response->assertStatus(200)
            ->assertJson([
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


    /**
     * Test untuk method store.
     *
     * Method ini bertujuan untuk mengetes apakah data kurir berhasil ditambahkan dengan benar.
     *
     * @return void
     */
    public function testStore()
    {
        // Data kurir yang akan ditambahkan
        $data = [
            'name' => 'Joni',
            'address' => 'Jl. Raya No. 123',
            'phone' => '081234567890',
            'action' => 'Success',
        ];

        // Melakukan HTTP request POST dengan data kurir yang akan ditambahkan
        $response = $this->post('/kurir', $data);

        // Assert HTTP response status 201 (Created) dan format JSON yang sesuai dengan expected data
        $response->assertStatus(201)->assertJson([
            'message' => 'Add Data Kurir Success',
            'data' => $data,
        ]);
    }


    /**
     * Test untuk method show.
     *
     * Method ini bertujuan untuk mengetes apakah data kurir dengan ID tertentu berhasil diambil dengan benar.
     * dengan metode HTTP GET mengembalikan response HTTP status 200 dan data JSON.
     * 
     * @return void
     */
    public function testShow()
    {
        // Membuat data kurir dengan factory
        $kurir = Kurir::factory()->create([
            'name' => 'Kurir Test',
            'address' => 'Jl. Raya No. 123',
            'phone' => '081234567890',
            'action' => 'Pending'
        ]);

        // Melakukan HTTP request GET ke halaman /kurir/{id} dengan parameter ID dari data kurir yang telah dibuat
        $response = $this->get('/kurir/' . $kurir->id);

        // Assert HTTP response status 200 (OK) dan format JSON yang sesuai dengan expected data
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


    /**
     * Test untuk method update.
     *
     * Method ini bertujuan untuk mengupdate data kurir berdasarkan ID yang ditentukan.
     * 
     *
     * @return void
     */
    public function testUpdate()
    {
        // Membuat data kurir dengan factory
        $kurir = Kurir::factory()->create([
            'name' => 'Jono',
            'address' => 'Jl. Raya No. 321',
            'phone' => '087654321098',
            'action' => 'On The Way',
        ]);

        // Melakukan HTTP request PATCH ke halaman /kurir/{id} dengan parameter ID dari data kurir yang telah dibuat
        $response = $this->patch('/kurir/' . $kurir->id, [
            'name' => 'Joni',
            'address' => 'Jl. Baru No. 123',
            'phone' => '081234567890',
            'action' => 'Success',
        ]);

        // Assert HTTP response status 200 (OK) dan format JSON yang sesuai dengan expected data
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data Kurir Updated Success',
                'data' => [
                    'id' => $kurir->id,
                    'name' => 'Joni',
                    'address' => 'Jl. Baru No. 123',
                    'phone' => '081234567890',
                    'action' => 'Success',
                ],
            ]);

        // Melakukan pengujian untuk kasus ketika ID kurir yang dimasukkan tidak ditemukan di database
        $response = $this->patch('/kurir/' . ($kurir->id + 1), [
            'name' => 'Joni',
            'address' => 'Jl. Baru No. 123',
            'phone' => '081234567890',
            'action' => 'Success',
        ]);

        $response->assertStatus(404);
    }


    /**
     * Test untuk method Delete.
     *
     * Method ini bertujuan untuk menghapus data kurir berdasarkan ID yang ditentukan yang ada pada database.
     * 
     *
     * @return void
     */
    public function testDelete()
    {
        // Membuat data kurir dengan factory
        $kurir = Kurir::factory()->create([
            "id" => 1,
            "name" => "Jono",
            "address" => "Jl. Raya No. 321",
            "phone" => "087654321098",
            "action" => "On The Way",
            "created_at" => "2023-05-11T08:18:42.000000Z",
            "updated_at" => "2023-05-11T08:18:42.000000Z"
        ]);

        // Melakukan HTTP request DELETE ke halaman /api/v1/kurir/{id} dengan parameter ID dari data kurir yang telah dibuat
        $response = $this->delete('/api/v1/kurir/' . $kurir->id);
        $response->assertStatus(200)->assertJson([
            "message" => "Delete Data Kurir Success",
            "data" => [
                "name" => "Jono",
                "address" => "Jl. Raya No. 321",
                "phone" => "087654321098",
                "action" => "On The Way",
                "created_at" => "2023-05-11T08:18:42.000000Z",
                "updated_at" => "2023-05-11T08:18:42.000000Z"
            ]
        ]);

        // pengecekan apakah data kurir dengan ID yang ditentukan sudah benar-benar dihapus dari database
        // memastikan bahwa data kurir telah dihapus dari database dengan menggunakan metode assertDatabaseMissing(),
        $this->assertDatabaseMissing('kurirs', ['id' => $kurir->id]);
    }
}
