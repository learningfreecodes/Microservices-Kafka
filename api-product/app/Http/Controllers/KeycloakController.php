<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreateTokenRequest;


class KeycloakController extends Controller
{

    /**
     *
     *
     * Get Token
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     *
     * @unauthenticated
     *
     */
    public function index (CreateTokenRequest $request)
    {
        $request->validated();
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie'       => 'KEYCLOAK_LOCALE=en'
        ])->asForm()->post('http://hubii_keycloak:8080/realms/hubii/protocol/openid-connect/token', [
                'grant_type' => 'password',
                'client_id' => 'api-products',
                'client_secret' => 'zTKRB6PIfM6bhj3kIG2yiZ8p5CcVcKfm',
                'username' => "$request->username",
                'password' => "$request->password",
                'scope' => 'openid'
        ]);
        return response($response);
    }

}
