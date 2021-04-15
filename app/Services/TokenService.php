<?php


namespace App\Services;


use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Support\Str;

class TokenService
{
    public function create($user): string
    {
        $token = self::generate();

        if (self::insertToDatabase($user, $token)) {
            $tokenHash = self::createHash($user, $token);

            return self::encrypt($tokenHash);
        } else {
            throw new Exception('Failed to insert token to database!');
        }
    }

    public function check($accountTypes = null): bool
    {
        try {
            $id = request()->cookie('id');
            $token = request()->cookie('token');
        } catch (Throwable $e) {
            throw new Exception('Failed to decrypt cookies!');
        }

        if (!$id or !$token) {
            return false;
        }

        if ($accountTypes !== null) {
            $user = User::whereIn('account_type_id', $accountTypes)->find($id);
        } else {
            $user = User::find($id);
        }

        if (!$user) {
            throw new Exception('User was not found!');
        }

        $tokens = $user->tokens()->get();
        $isTokenHasAccess = false;

        foreach ($tokens as $item) {
            $hash = self::createHash($user, $item->token);

            if ($hash === $token) {
                $isTokenHasAccess = true;
            }
        }

        return $isTokenHasAccess;
    }

    private function generate(): string
    {
        return Str::random(32);
    }

    private function insertToDatabase($user, $token)
    {
        return $user->tokens()->create([
            'token' => $token
        ]);
    }

    private function encrypt($tokenHash): string
    {
        return encrypt($tokenHash, false);
    }

    private function createHash($user, $token): string
    {
        $userAgent = request()->header('User-Agent');
        $passwordHash = $user->password;

        return hash('sha256', substr($token, 0, 14) . substr($passwordHash, 0, 47)
            . hash('sha256', $userAgent) . 'lY.6@ut/39PS' . substr($token, 14));
    }
}
