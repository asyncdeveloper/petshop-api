<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 *  @OA\Server(
 *    url=L5_SWAGGER_CONST_HOST,
 *    description="Pet Shop API"
 *  )
 *  @OA\Info(
 *    title="Pet Shop API - Swagger Documentation",
 *    description="Pet Shop API",
 *    version="1.0.0",
 *    termsOfService="https://swagger.io/terms/",
 *    @OA\Contact(
 *      email="contact@asyncdeveloper.com"
 *    ),
 *   )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
