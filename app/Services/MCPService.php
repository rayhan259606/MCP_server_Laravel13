<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MCPService
{
    /**
     * Handle the incoming tool request.
     */
    public function handle($tool, $input)
    {
        Log::info("MCP Tool Called: $tool", ['input' => $input]);

        return match ($tool) {
            'user_action'       => $this->userAction($input),
            'memory_action'     => $this->memoryAction($input),
            'navigation_action' => ['status' => 'success', 'message' => 'Navigating...'],
            'system_info'       => $this->getSystemInfo(),
            default             => ['error' => 'Tool not found: ' . $tool],
        };
    }

    /**
     * Handle memory-related actions.
     */
    private function memoryAction($input)
    {
        $action = $input['action'] ?? null;

        return match ($action) {
            'save' => $this->saveMemory($input),
            'get'  => $this->getMemories(),
            default => ['error' => 'Invalid memory action'],
        };
    }

    private function saveMemory($input)
    {
        if (empty($input['content'])) {
            return ['error' => 'Memory content is empty'];
        }

        \App\Models\Memory::create([
            'content' => $input['content']
        ]);

        return [
            'status' => 'success',
            'message' => 'Memory saved successfully.'
        ];
    }

    private function getMemories()
    {
        $memories = \App\Models\Memory::latest()->take(5)->get();
        return [
            'status' => 'success',
            'data' => $memories
        ];
    }

    /**
     * Handle user-related actions.
     */
    private function userAction($input)
    {
        $action = $input['action'] ?? null;

        try {
            return match ($action) {
                'create' => $this->createUser($input),
                'delete' => $this->deleteUser($input),
                'update' => $this->updateUser($input),
                'list'   => $this->listUsers(),
                default  => ['error' => 'Invalid user action: ' . $action],
            };
        } catch (\Exception $e) {
            Log::error("MCP User Action Error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    private function createUser($input)
    {
        if (empty($input['name'])) {
            throw new \Exception("Name is required to create a user.");
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => strtolower(str_replace(' ', '.', $input['name'])) . '@example.com',
            'password' => Hash::make('password123')
        ]);

        return [
            'status' => 'success',
            'message' => "User {$user->name} created successfully.",
            'data' => $user
        ];
    }

    private function deleteUser($input)
    {
        $id = $input['id'] ?? null;
        if (!$id) {
            // Try to find by name if ID isn't provided
            $name = $input['name'] ?? null;
            if ($name) {
                $user = User::where('name', 'like', "%$name%")->first();
                $id = $user?->id;
            }
        }

        if (!$id) {
            throw new \Exception("User ID or Name required for deletion.");
        }

        $deleted = User::destroy($id);
        
        return [
            'status' => $deleted ? 'success' : 'error',
            'message' => $deleted ? "User deleted successfully." : "User not found."
        ];
    }

    private function updateUser($input)
    {
        $id = $input['id'] ?? null;
        if (!$id) {
            $name = $input['old_name'] ?? null;
            if ($name) {
                $user = User::where('name', 'like', "%$name%")->first();
                $id = $user?->id;
            }
        }

        if (!$id) {
            throw new \Exception("User identification required for update.");
        }

        $user = User::findOrFail($id);
        if (!empty($input['name'])) {
            $user->name = $input['name'];
        }
        $user->save();

        return [
            'status' => 'success',
            'message' => "User updated to {$user->name}.",
            'data' => $user
        ];
    }

    private function listUsers()
    {
        $users = User::latest()->take(5)->get();
        return [
            'status' => 'success',
            'count' => $users->count(),
            'data' => $users
        ];
    }

    /**
     * Get basic system information.
     */
    private function getSystemInfo()
    {
        return [
            'status' => 'online',
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'database' => config('database.default'),
            'user_count' => User::count(),
        ];
    }
}

