<?php

namespace App\Modules\Project;

use App\Http\Controllers\Controller;
use App\Modules\Project\ProjectService;
use App\Modules\Project\Resources\ProjectResource;
use App\Modules\Project\Requests\ProjectStoreRequest;
use App\Modules\Project\Requests\ProjectUpdateRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->middleware('auth');
        $this->projectService = $projectService;
    }

    /**
     * @OA\GET(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Get Projects list",
     *     description="Get Projects List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Project::class);
            
            $projects = $this->projectService->paginate($request->all());
            return ProjectResource::collection($projects);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Get Project detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            $this->authorize('view', Project::class);

            $project = $this->projectService->getOneOrFail($id, $request->all());
            return new ProjectResource($project);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Create a new Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(ProjectStoreRequest $request)
    {
        try {
            $this->authorize('create', Project::class);

            $payload = $request->validated();
            $project = $this->projectService->createOne($payload);

            return new ProjectResource($project);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Update an existing Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(ProjectUpdateRequest $request, int $id)
    {
        try {
            $this->authorize('update', Project::class);

            $payload = $request->validated();
            $project = $this->projectService->updateOne($id, $payload);

            return new ProjectResource($project);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/projects/{id}",
     *     tags={"Projects"},
     *     summary="Delete a Project",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(int $id)
    {
        try {
            $this->authorize('delete', Project::class);

            $project = $this->projectService->deleteOne($id);
            return new ProjectResource($project);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/projects/{id}/restore",
     *     tags={"Projects"},
     *     summary="Restore a Project from trash",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function restore(int $id)
    {
        try {
            $this->authorize('restore', Project::class);

            $project = $this->projectService->restoreOne($id);
            return new ProjectResource($project);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
