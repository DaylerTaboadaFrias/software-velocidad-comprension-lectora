<?php

namespace App\Http\Controllers\Api;

use stdClass;
use App\Models\User;
use Aws\S3\S3Client;
use App\Models\Photo;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Aws\Rekognition\RekognitionClient;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    use ApiResponder;

    /**
     * @throws ValidationException
     */
    public function login(): JsonResponse {
        request()->validate([
            "email" => "required|email",
            "password" => "required|min:8|max:30",
            "device_name" => "required",
        ]);

        $user = User::select(["id", "name", "password", "email", "photo1", "photo2", "photo3"])
            ->where("email", request("email"))
            ->first();

        if (! $user || ! Hash::check(request("password"), $user->password)) {
            throw ValidationException::withMessages([
                "email" => [__("Credenciales incorrectas")]
            ]);
        }

        $token = $user->createToken(request("device_name"))->plainTextToken;

        return $this->success(
            __("Bienvenid@"),
            [
                "user" => $user->toArray(),
                "token" => $token,
            ]
        );
    }

    public function signup(): JsonResponse {
        request()->validate([
            "name" => "required|min:2|max:60",
            "email" => "required|email|unique:users",
            "password" => "required|min:8|max:30",
            "passwordConfirmation" => "required|same:password|min:8|max:30",
        ]);

        User::create([
            "name" => request("name"),
            "email" => request("email"),
            "password" => bcrypt(request("password")),
            "created_at" => now(),
            "role" => 'Cliente',
        ]);

        return $this->success(
            __("¡¡Cuenta creada!!")
        );
    }

    public function logout(): JsonResponse {
        $token = request()->bearerToken();

        /** @var PersonalAccessToken $model */
        $model = Sanctum::$personalAccessTokenModel;

        $accessToken = $model::findToken($token);
        $accessToken->delete();

        return $this->success(
            __("Hasta la próxima!"),
            null
        );
    }

    
    
}
