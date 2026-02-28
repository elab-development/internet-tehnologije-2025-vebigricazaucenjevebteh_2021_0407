<?php

namespace Tests\Feature;

use Tests\TestCase;

class DailyTest extends TestCase
{
    public function test_daily_route_returns_question()
    {
        $response = $this->getJson('/api/daily');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'date',
            'question',
            'correct_answer',
            'answers'
        ]);
    }
}
