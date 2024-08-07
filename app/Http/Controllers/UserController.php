<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @OA\Info(
 *     title="Users API",
 *     version="1.0.0"
 * )
 */
class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     operationId="getUsers",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     description="Returns list of users",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->all();
        if (empty($data['page'])) $data['page'] = 1;
        if (empty($data['perPage'])) $data['perPage'] = env('PAGINATION_COUNT', 10);

        return response()->json([
            'is_success' => true,
            'data' => $this->userRepository->getItems($data)->items()

        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/user",
     *     operationId="storeUser",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     description="Creates a new user and returns the user data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="name3"),
     *             @OA\Property(property="email", type="string", example="name3@mail.ru"),
     *             @OA\Property(property="password", type="string", example="11111112")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The email has already been taken."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->all();
        return response()->json([
            'is_success' => true,
            'data' => $this->userRepository->storeItem($data)

        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     operationId="showUser",
     *     tags={"Users"},
     *     summary="Get user details",
     *     description="Returns the details of a specific user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found.")
     *         )
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'is_success' => true,
            'data' => $user
        ]);
    }


    /**
     * @OA\Put(
     *     path="/api/user/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Update user data",
     *     description="Updates data for a specific user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="новое имя"),
     *             @OA\Property(property="email", type="string", example="newemail@mail.ru"),
     *             @OA\Property(property="password", type="string", example="новый пароль")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The email has already been taken."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if (empty($user)) {
            return response()->json([
                'is_success' => false,
                'data' => []
            ]);
        }
        $data = $request->all();

        return response()->json([
            'is_success' => true,
            'data' => $this->userRepository->updateItem($user, $data)
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Delete user",
     *     description="Deletes a specific user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="is_success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        if (empty($user)) {
            return response()->json([
                'is_success' => false,
            ]);
        }

        return response()->json([
            'is_success' => $this->userRepository->destroyItem($user),
        ]);
    }
}
