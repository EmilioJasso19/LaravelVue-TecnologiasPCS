<?php

namespace App\Http\Controllers;

use App\Models\EducationalExperience;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{educationalExperience}/groups",
     *     summary="Mostrar todos los grupos de una experiencia educativa",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los grupos de la experiencia educativa"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function index($educationalExperience)
    {

        $groups = Group::where('educational_experience_id', $educationalExperience)->get();
        return response()->json($groups, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{educationalExperience}/groups/create",
     *     summary="Mostrar los detalles de la experiencia educativa para crear un grupo",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la experiencia educativa"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function create($educationalExperience)
    {
        $educationalExperience = EducationalExperience::findOrFail($educationalExperience);
        return response()->json($educationalExperience, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/educational-experiences/{educationalExperience}/groups",
     *     summary="Crear un nuevo grupo en una experiencia educativa",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Nombre del grupo"),
     *             @OA\Property(property="shift", type="string", description="Turno del grupo"),
     *             @OA\Property(property="period", type="string", description="Periodo del grupo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Grupo creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function store(Request $request, $teacherId)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'shift' => 'required|string|max:12',
            'period' => 'required|string|max:45'
        ]);

        $group = Group::create([
            'educational_experience_id' => $request->educationalExperienceId,
            'teacher_id' => $teacherId,
            'name' => $request->name,
            'shift' => $request->shift,
            'period' => $request->period,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => $teacherId
        ]);

        return response()->json([
            'message' => 'Grupo creado exitosamente',
            'data' => $group
        ],201);
    }

    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{educationalExperience}/groups/{groupId}",
     *     summary="Mostrar un grupo por su ID",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID del grupo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del grupo"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function show($groupId)
    {
        $group = Group::findOrFail($groupId);

        return Inertia::render('Groups/GroupShow', [
            'group' => $group,
            'educationalExperience' => $group->educationalExperience ?? null,
            'teacher' => $group->teacher ?? null,
        ]);
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
     *     path="/api/educational-experiences/{educationalExperience}/groups/{groupId}",
     *     summary="Actualizar un grupo",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID del grupo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Nombre del grupo"),
     *             @OA\Property(property="shift", type="string", description="Turno del grupo"),
     *             @OA\Property(property="period", type="string", description="Periodo del grupo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function update(Request $request, $group)
    {
        $group = Group::findOrFail($group);

        $request->validate([
            'name' => 'required|string|max:45',
            'shift' => 'required|string|max:12',
            'period' => 'required|string|max:45'
        ]);


        $group->update([
            'educational_experience_id' => $group->educational_experience_id,
            'teacher_id' => $group->teacher_id,
            'name' => $request->name,
            'shift' => $request->shift,
            'period' => $request->period,
            'updated_at' => Carbon::now(),
            'updated_by' => Auth::id()
        ]);


        return response()->json([
            'message' => 'Se ha editado el grupo con exito.',
            'data' => $group
        ],201);
    }

    /**
     * @OA\Delete(
     *     path="/api/educational-experiences/{educationalExperience}/groups/{groupId}",
     *     summary="Eliminar un grupo",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID del grupo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Grupo eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function destroy($groupId)
    {
        $group = Group::findOrFail($groupId);
        $group->deleted_by = Auth::id();
        $group->save();
        $group->delete();

        return response()->json([
            'message' => 'Se ha eliminado el grupo correctamente.'
        ],201);
    }

    public function teacherGroups($teacherId)
    {
        $groups = Group::where('teacher_id', $teacherId);
        return response()->json($groups, 201);
    }


    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{educationalExperience}/groups/{groupId}/students",
     *     summary="Obtener los estudiantes de un grupo",
     *     @OA\Parameter(
     *         name="educationalExperience",
     *         in="path",
     *         description="ID de la experiencia educativa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID del grupo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de estudiantes en el grupo"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error"
     *     )
     * )
     */
    public function studentsByGroup($groupId){
//        $students = User::join('enrollments', 'users.id', '=', 'enrollments.student_id')
//            ->where('enrollments.group_id', $groupId)
//            ->select('users.*')->get();

//        $group = Group::findOrFail($groupId);
//        $students = $group->students;

        $students = User::whereHas('enrollments', function($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->get();

        return response()->json($students, 201);

    }
}
