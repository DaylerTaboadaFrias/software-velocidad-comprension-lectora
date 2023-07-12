<?php

namespace App\Http\Controllers\Api;

use Exception;
use stdClass;
use App\Models\User;
use Aws\S3\S3Client;
use App\Models\Nivel;
use App\Models\Categoria;
use App\Models\Ejercicio;
use App\Models\Respuesta;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Aws\Rekognition\RekognitionClient;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;
use Aws\TranscribeService\TranscribeServiceClient;


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

        $user = User::select(["id", "name", "password", "email", "photo1"])
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
            "created_at" => now()
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

    public function listarCategorias(): JsonResponse {
        $categorias = Categoria::get();
        return $this->success(
            "Categorias",
            $categorias->toArray(),
        );
    }
    public function listarNiveles(Request $request): JsonResponse {
        $niveles = Nivel::where('categoria_id' ,$request->categoriaId)->get();
        return $this->success(
            "Niveles",
            $niveles->toArray(),
        );
    }
    public function obtenerRespuesta(Request $request): JsonResponse {
        $ejercicio = Respuesta::where('ejercicio_id' ,$request->ejercicioId)->where('user_id' ,$request->userId)->first();
        return $this->success(
            "Respuesta",
            $ejercicio,
        );
    }
    public function listarEjercicios(Request $request): JsonResponse {
        $ejercicios = Ejercicio::where('nivel_id' ,$request->nivelId)->get();
        return $this->success(
            "Ejercicios",
            $ejercicios->toArray(),
        );
    }

    public function obtenerRecomendaciones(Request $request): JsonResponse {
        $ejercicios = Ejercicio::select('id')->where('nivel_id' ,$request->nivelId)->get()->toArray();
        $respuestas = Respuesta::whereIn('ejercicio_id',$ejercicios)->get();
        foreach ($respuestas as $item) {
            $total = $item->palabrasCorrectas + $item->palabrasIncorrectas;
            if($item->intentos >= 3  ){

            }
            if($item->intentos_lectura >= 3 ){

            }
        }
        dd($respuestas);
        return $this->success(
            "Ejercicios",
            $ejercicios->toArray(),
        );
    }

    public function enviarIntento(Request $request): JsonResponse
    {
        $respuestaAnterior = Respuesta::where('user_id',$request->userId)->where('ejercicio_id',$request->ejercicioId)->first();
        if($respuestaAnterior){
            $respuestaAnterior->intentos_lectura =  $respuestaAnterior->intentos_lectura + 1;
            $respuestaAnterior->save();
        }else{
            $respuestaAnterior = new Respuesta;
            $respuestaAnterior->palabrasIncorrectas = 0;
            $respuestaAnterior->palabrasCorrectas = 0;
            $respuestaAnterior->intentos =  0;
            $respuestaAnterior->intentos_lectura =  1;
            $respuestaAnterior->user_id = $request->userId;
            $respuestaAnterior->ejercicio_id =  $request->ejercicioId;
            $respuestaAnterior->save();
        }
        return $this->success(
            "Respuesta",
            $respuestaAnterior->toArray(),
        );
    }
    public function enviarRespuesta(Request $request): JsonResponse {
        $validatedData = $request->validate([
            'audio' => 'required',
            'audio.*' => 'mimes:wav',
            'ejercicioId' => 'required',
            'userId' => 'required'
            ]);
            $fechaRegistro = date('YmdHis');
            $transcriptionJobName = $fechaRegistro;
            $FileName = $fechaRegistro.'.wav';
            $bucketName = 'pruebataboada';
            $respuesta = '';
            $IAM_KEY = 'AKIA4E32AUYY5VFGD5HP';
            $IAM_SECRET = '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';
            try {
                $s3 = S3Client::factory(
                    array(
                    'credentials' => array(
                        'key' => $IAM_KEY,
                        'secret' => $IAM_SECRET
                    ),
                    'version' => 'latest',
                    'region'  => 'us-west-1'
                    )
                );
            } catch (Exception $e) {
                $this->error(
                    $e->getMessage()
                );
            }
            $client2 = new TranscribeServiceClient([
                'version' => 'latest',
                'region' => 'us-west-1', // Reemplaza con la región correspondiente
                'credentials' => [
                    'key' => 'AKIA4E32AUYY5VFGD5HP',
                    'secret' => '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',
                ],
            ]);

            if($request->hasfile('audio'))
            {
                   $user =  User::find(request('userId'));
                   $destinationPath = 'images/';
                   $file = $_FILES["audio"]['tmp_name'];
                   //$FileName = basename($_FILES["audio"]["name"]);
                   $profileImage = date('YmdHis') . "." . $request->file('audio')->getClientOriginalExtension();
                   $s3->putObject(
                        array(
                        'Bucket'=>$bucketName,
                        'Key' =>  $FileName,
                            'SourceFile' => $file,
                        'StorageClass' => 'REDUCED_REDUNDANCY',
                        'ACL'  => 'public-read'
                        )
                    );
                    // Nombre para el trabajo de transcripción
                    $languageCode = 'es-ES'; // Código de idioma del audio (puede ser 'en-US' para inglés)
                    $outputBucket = 'pruebataboada'; // Nombre del bucket de S3 donde se guardarán los resultados
                    $response = $client2->startTranscriptionJob([
                        'TranscriptionJobName' => $transcriptionJobName,
                        'LanguageCode' => $languageCode,
                        'Media' => [
                            'MediaFileUri' => 's3://pruebataboada/'.$FileName,
                        ]
                    ]);
                    $status = array();
                    while(true) {
                        $status = $client2->getTranscriptionJob([
                            'TranscriptionJobName' => $transcriptionJobName
                        ]);

                        if ($status->get('TranscriptionJob')['TranscriptionJobStatus'] == 'COMPLETED') {
                            break;
                        }

                        sleep(5);
                    }
                    // download the converted txt file
                    $url = $status->get('TranscriptionJob')['Transcript']['TranscriptFileUri'];
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    $data = curl_exec($curl);
                    if (curl_errno($curl)) {
                        $error_msg = curl_error($curl);
                        echo $error_msg;
                    }
                    curl_close($curl);
                    $arr_data = json_decode($data);

                    $respuesta = ($arr_data->results->transcripts[0]->transcript);
                    $ejercicio = Ejercicio::where('id',$request->ejercicioId)->first();

                    $parrafoOriginal = $ejercicio->parrafo;
                    $resumenUsuario = $respuesta;
                    $resultado = $this->compararParrafos($parrafoOriginal, $resumenUsuario);
                    $cadenaRespuesta = '';
                    $cadenaRespuesta = 'Acertaste '.count($resultado['acertadas']). ' palabras de '.count($resultado['fallidas']) ;
                    $respuestaAnterior = Respuesta::where('user_id',$request->userId)->where('ejercicio_id',$request->ejercicioId)->first();
                    if($respuestaAnterior){
                        $respuestaAnterior->palabrasIncorrectas = count($resultado['fallidas']);
                        $respuestaAnterior->palabrasCorrectas = count($resultado['acertadas']) ;
                        $respuestaAnterior->intentos =  $respuestaAnterior->intentos + 1;
                        $respuestaAnterior->save();
                    }else{
                        $respuestaAnterior = new Respuesta;
                        $respuestaAnterior->palabrasIncorrectas = count($resultado['fallidas']);
                        $respuestaAnterior->palabrasCorrectas = count($resultado['acertadas']) ;
                        $respuestaAnterior->intentos =  1;
                        $respuestaAnterior->intentos_lectura =  1;
                        $respuestaAnterior->user_id = $request->userId;
                        $respuestaAnterior->ejercicio_id =  $request->ejercicioId;
                        $respuestaAnterior->save();
                    }
                   $request->file('audio')->move($destinationPath, $profileImage);
            }
        return $this->success(
            "Respuesta",
            $respuestaAnterior
        );
    }
    public function uploadProfile1(Request $request): JsonResponse {
        $validatedData = $request->validate([
            'image' => 'required',
            'image.*' => 'mimes:jpg,png'
            ]);

            if($request->hasfile('image'))
            {
                   $user =  User::find(request('userId'));
                   $destinationPath = 'images/';
                   $profileImage = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
                   $request->file('image')->move($destinationPath, $profileImage);
                   $input['imagen'] = "$profileImage";
                   $user->photo1 = $profileImage;
                   $user->save();
            }
        return $this->success(
            $user->photo1
        );
    }

    function compararParrafos($parrafoOriginal, $resumenUsuario) {
        // Convertir los párrafos a arrays de palabras
        $palabrasOriginal = preg_split('/\s+/', $parrafoOriginal);
        $palabrasUsuario = preg_split('/\s+/', $resumenUsuario);
        $palabrasOriginalFiltradas = array_filter($palabrasOriginal, function($palabra) {
            return strlen($palabra) > 1;
        });
        // Obtener las palabras en las que acertó y en las que no
        $palabrasAcertadas = array_intersect($palabrasOriginal, $palabrasUsuario);
        $palabrasFallidas = array_diff($palabrasOriginal, $palabrasUsuario);

        // Retornar los resultados
        return array(
            'acertadas' => $palabrasAcertadas,
            'fallidas' => $palabrasFallidas
        );
    }
}
