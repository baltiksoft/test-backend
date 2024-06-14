<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdsTest extends TestCase
{
    /**
     * Получить все записи
     */
    public function testAll(): void
    {
        $response = $this->getJson('/api/ads');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Получить все записи с пагинацией
     */
    public function testPagination(): void
    {
        $response = $this->getJson('/api/ads/1/2');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Получить все записи с пагинацией и сортировкой
     */
    public function testSort(): void
    {
        $response = $this->getJson('/api/ads/0/10/price/desc');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * Получить запись по идентификатору
     */
    public function testShow(): void
    {
        $response = $this->getJson('/api/ads/obieiavlenie-1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['name' => 'Объявление 1']
            ]);
    }
}
