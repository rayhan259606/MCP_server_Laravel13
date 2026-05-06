<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;
    protected $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key');
    }

    /**
     * Process natural language text and determine the intent/tool.
     */
    public function processIntent($text)
    {
        if (!$this->apiKey) {
            return ['error' => 'OpenRouter API Key not found in .env'];
        }

        $prompt = "You are a Voice Assistant for a Laravel app. 
        Your job is to parse the user's intent into a JSON object for a Tool-Call.
        
        Available Tools:
        1. user_action: {action: 'create', name: 'NAME'} or {action: 'list'} or {action: 'delete', name: 'NAME'}
        2. memory_action: {action: 'save', content: 'TEXT'} or {action: 'get'}
        3. navigation_action: {page: 'login' | 'register' | 'career' | 'home'}
        4. form_fill_action: {}
        5. form_submit_action: {}
        6. system_info: {}

        User Input: \"$text\"

        Return ONLY a JSON object in this format: 
        { \"tool\": \"TOOL_NAME\", \"input\": { \"KEY\": \"VALUE\" } }
        If you don't understand, return: { \"error\": \"Unknown intent\" }";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
            ])->post($this->baseUrl, [
                'model' => 'google/gemini-2.0-flash-001', // You can change the model
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'response_format' => ['type' => 'json_object']
            ]);

            if ($response->failed()) {
                Log::error("OpenRouter Error: " . $response->body());
                return ['error' => 'AI Service Error'];
            }

            $result = $response->json();
            $content = $result['choices'][0]['message']['content'];
            
            return json_decode($content, true);

        } catch (\Exception $e) {
            Log::error("AI Processing Exception: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
