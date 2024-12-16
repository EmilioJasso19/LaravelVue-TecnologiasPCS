<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(title="API Eplus v 0.0.1", version="1.0")
 *
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Mostrar usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los usuarios."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"roleId", "tuition", "name", "lastName", "motherLastName", "email", "password"},
     *             @OA\Property(property="roleId", type="integer", description="ID del rol del usuario"),
     *             @OA\Property(property="tuition", type="string", description="Matrícula del usuario"),
     *             @OA\Property(property="name", type="string", description="Nombre del usuario"),
     *             @OA\Property(property="lastName", type="string", description="Apellido paterno del usuario"),
     *             @OA\Property(property="motherLastName", type="string", description="Apellido materno del usuario"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del usuario"),
     *             @OA\Property(property="password", type="string", description="Contraseña del usuario"),
     *             @OA\Property(property="universityCareer", type="string", description="Carrera universitaria del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario dado de alta exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'roleId' => 'required|numeric',
            'tuition' => 'required|max:12',
            'name' => 'required|string|max:45',
            'lastName'=> 'required|string|max:45',
            'motherLastName' => 'required|string|max:45',
            'email' => 'required|email|string|max:255',
            'password'=> 'required|string|max:255',
            'universityCareer' => 'nullable|string',
        ]);

        $user = User::create([
            'role_id' => $request->roleId,
            'tuition'=>$request->tuition,
            'name'=>$request->name,
            'last_name'=>$request->lastName,
            'mother_last_name'=>$request->motherLastName,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'university_career'=>$request->universityCareer,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Usuario dado de alta de alta exitosamente',
            'data' => $user,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{userId}",
     *     summary="Mostrar un usuario por su ID",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function show( $userId)
    {
        $user = User::findOrFail($userId);
        return response()->json($user, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/users/{userId}",
     *     summary="Actualizar un usuario existente",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"roleId", "tuition", "name", "lastName", "motherLastName", "email", "password"},
     *             @OA\Property(property="roleId", type="integer", description="ID del rol del usuario"),
     *             @OA\Property(property="tuition", type="string", description="Matrícula del usuario"),
     *             @OA\Property(property="name", type="string", description="Nombre del usuario"),
     *             @OA\Property(property="lastName", type="string", description="Apellido paterno del usuario"),
     *             @OA\Property(property="motherLastName", type="string", description="Apellido materno del usuario"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico del usuario"),
     *             @OA\Property(property="password", type="string", description="Contraseña del usuario"),
     *             @OA\Property(property="universityCareer", type="string", description="Carrera universitaria del usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario editado exitosamente"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'roleId' => 'required|numeric',
            'tuition' => 'required|max:12',
            'name' => 'required|string|max:45',
            'lastName'=> 'required|string|max:45',
            'motherLastName' => 'required|string|max:45',
            'email' => 'required|email|string|max:255',
            'password'=> 'required|string|max:255',
            'universityCareer' => 'nullable|string',
        ]);

        $user->update([
            'role_id' => $request->roleId,
            'tuition'=>$request->tuition,
            'name'=>$request->name,
            'last_name'=>$request->lastName,
            'mother_last_name'=>$request->motherLastName,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'university_career'=>$request->universityCareer,
            'updated_at' => Carbon::now(),
            'updated_by' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Usuario editado exitosamente.',
            'user' => $user
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{userId}",
     *     summary="Eliminar un usuario",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Se ha eliminado el usuario.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        $user->deleted_by = Auth::id();
        $user->save();
        $user->delete();

        return response()->json([
            'message' => 'Se ha eliminado el usuario.'
        ], 201);
    }
}
