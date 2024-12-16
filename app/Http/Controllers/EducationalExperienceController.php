<?php

namespace App\Http\Controllers;

use App\Models\EducationalExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationalExperienceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/educational-experiences",
     *     summary="Mostrar experiencias educativas",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos las experiencias educativas."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {
        $educationalExperiences = EducationalExperience::all();
        $educativePrograms = EducationalExperience::$educativeProgram;
        return response()->json([
            'educationalExperiences' => $educationalExperiences,
            'educativePrograms' => $educativePrograms,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/educational-experiences/create",
     *     summary="Mostrar formulario para crear una nueva experiencia educativa",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna los programas educativos disponibles medidante un arreglo en el modelo.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function create()
    {
        $educativeProgram = EducationalExperience::$educativeProgram;
        return response()->json($educativeProgram, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/educational-experiences",
     *     summary="Crear una nueva experiencia educativa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nrc","name","modality","educativeProgram"},
     *             @OA\Property(property="nrc", type="string", maxLength=5),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="modality", type="string"),
     *             @OA\Property(property="educativeProgram", type="integer"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Experiencia educativa creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
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
            'nrc' => 'required|string|max:5',
            'name' => 'required|string',
            'modality' => 'required|string',
            'educativeProgram' => 'required|numeric',
            'description' => 'nullable|string'
        ]);

        EducationalExperience::create([
            'nrc' => $request->nrc,
            'name' => $request->name,
            'modality' => $request->modality,
            'educative_program' => $request->educativeProgram,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => "Experiencia educativa creada exitosamente",
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{id}",
     *     summary="Mostrar una experiencia educativa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna los detalles de una experiencia educativa.",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function show( $educationalExperience)
    {
        $educationalExp = EducationalExperience::findOrFail($educationalExperience);
        return response()->json([
            'data' => $educationalExp
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/educational-experiences/{id}/edit",
     *     summary="Mostrar formulario para editar una experiencia educativa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna los detalles de la experiencia educativa seleccionada para su edición.",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function edit( $educationalExperienceId)
    {
        $educationalExperience = EducationalExperience::findOrFail($educationalExperienceId);
        return response()->json($educationalExperience, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/educational-experiences/{id}",
     *     summary="Actualizar una experiencia educativa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nrc","name","modality"},
     *             @OA\Property(property="nrc", type="string", maxLength=5),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="modality", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Experiencia educativa actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function update(Request $request,  $educationalExperience)
    {
        $educationalExp = EducationalExperience::findOrFail($educationalExperience);
        $request->validate([
            'nrc' => 'required|string|max:5',
            'name' => 'required|string',
            'modality' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $educationalExp->update([
            'nrc' => $request->nrc,
            'name' => $request->name,
            'modality' => $request->modality,
            'description' => $request->description,
            'updated_at' => Carbon::now(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'message' => "Experiencia editada exitosamente",
            'data' => $educationalExp,
        ], 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/educational-experiences/{id}",
     *     summary="Eliminar una experiencia educativa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Experiencia educativa eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function destroy ($educationalExperienceId)
    {

        $educationalExperience = EducationalExperience::findOrFail($educationalExperienceId);
        $educationalExperience->deleted_at = Carbon::now();
        $educationalExperience->save();
        $educationalExperience->delete();
        return response()->json([
            'message' => 'Experiencia educativa eliminada exitosamente.'
        ], 201);
    }
}
