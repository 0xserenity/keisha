<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class StoryController
{
    public function __invoke(Request $request): Response
    {
        return Jetstream::inertia()
            ->render($request, 'Story', [
                'story' => [
                    'title' => 'Dogs and people',
                    'content' => 'For hundreds of years people have trained dogs, using a language of signals and commands.'
                ],
                'imageUrl' => 'https://cdn.discordapp.com/attachments/1189073660154220565/1201245360882978866/kimtrong22289_Illustrate_a_realistic_scene_featuring_dogs_and_p_7193780c-34c9-48ca-a98e-a4bf9b59d34a.png'
            ]);
    }
}