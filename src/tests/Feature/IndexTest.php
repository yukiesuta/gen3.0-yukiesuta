<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\BigQuestion;


class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $answer = factory(BigQuestion::class)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('東京の難読地名クイズ');
        $response->assertSee('広島の難読地名クイズ');
        $response->assertSee($answer->name);
    }
}
