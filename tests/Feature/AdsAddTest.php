<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdsAddTest extends TestCase
{
    /**
     * Добавление объявления
     */
    public function testAdsAdd(): void
    {
        $response = $this->postJson('/api/ads',
            [
                'name' => 'Объявление 1',
                'description' => 'Описание объявления 1',
                'price' => 1000,
                'filenames' => [
                    'https://example.com/images/1.jpg',
                    'https://example.com/images/2.jpg'
                ]
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);
    }

    public function testAdsAddValidationError(): void
    {
        $response = $this->postJson('/api/ads', []);
        $response->assertStatus(422);

        $response = $this->postJson('/api/ads',
            [
                'name' => 'Объявление 2',
                'description' => 'Описание объявления 2',
                'price' => 1400,
                'filenames' => [
                    'https://example.com/images/1.jpg',
                    'https://example.com/images/2.jpg',
                    'https://example.com/images/3.jpg',
                    'https://example.com/images/4.jpg'
                ]
            ]
        );
        $response->assertStatus(422);

    }
}
