<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MCPService;
use App\Services\AIService;

class MCPController extends Controller
{
    protected $mcp;
    protected $ai;

    public function __construct(MCPService $mcp, AIService $ai)
    {
        $this->mcp = $mcp;
        $this->ai = $ai;
    }

    public function handle(Request $request)
    {
        return response()->json(
            $this->mcp->handle(
                $request->input('tool'),
                $request->input('input')
            )
        );
    }

    /**
     * Process natural language via AI.
     */
    public function process(Request $request)
    {
        $text = $request->input('text');
        
        // 1. Get AI to decide what tool to call
        $aiResult = $this->ai->processIntent($text);

        if (isset($aiResult['error'])) {
            return response()->json($aiResult);
        }

        // 2. Execute the tool
        $tool = $aiResult['tool'] ?? null;
        $input = $aiResult['input'] ?? [];

        if ($tool) {
            $executionResult = $this->mcp->handle($tool, $input);
            return response()->json([
                'ai' => $aiResult,
                'result' => $executionResult
            ]);
        }

        return response()->json(['error' => 'No tool found by AI']);
    }
}
