<?php

namespace App\Modules\JobDetail;

use App\Http\Controllers\Controller;
use App\Modules\JobDetail\JobDetailService;
use App\Modules\JobDetail\Resources\JobDetailResource;
use App\Modules\JobDetail\Requests\JobDetailStoreRequest;
use App\Modules\JobDetail\Requests\JobDetailUpdateRequest;
use App\Modules\JobDetail\Requests\JobDetailUserRequest;
use App\Modules\Profile\Profile;
use Illuminate\Http\Request;

class JobDetailController extends Controller
{
    protected $jobDetailService;

    public function __construct(JobDetailService $jobDetailService)
    {
        $this->middleware('auth');
        $this->jobDetailService = $jobDetailService;
    }

    public function getJobDetails(JobDetailUserRequest $request)
    {
        try {
            $payload = $request->validated();

            $jobDetails = JobDetail::where(
                'workspace_id',
                $payload['workspace_id']
            )->with([
                'employeeType',
                'role',
                'department',
                'profile',
            ])->get();

            return $this->sendSuccess(
                'Job Details retrieved successfully',
                JobDetailResource::collection($jobDetails)
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function info(Request $request)
    {
        try {
            $request->validate([
                'workspace_id' => 'required|exists:workspaces,id,deleted_at,NULL',
            ]);

            $profile = Profile::where('user_id', $request->user()->id)
                ->where('workspace_id', $request->workspace_id)
                ->first();

            $jobDetail = JobDetail::where('profile_id', $profile->id)
                ->with([
                    'employeeType',
                    'role',
                    'department',
                    'profile',
                ])
                ->first();

            return $this->sendSuccess(
                'Job Detail info',
                new JobDetailResource($jobDetail)
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/job-details",
     *     tags={"Job Details"},
     *     summary="Get Job Details list",
     *     description="Get Job Details List as Array",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', JobDetail::class);

            $jobDetails = $this->jobDetailService->paginate($request->all());
            return JobDetailResource::collection($jobDetails);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/api/job-details/{id}",
     *     tags={"Job Details"},
     *     summary="Get Job Detail detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Request $request, int $id)
    {
        try {
            // $this->authorize('view', JobDetail::class);

            $jobDetail = $this->jobDetailService->getOneOrFail($id, $request->all());
            return new JobDetailResource($jobDetail);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/job-details/{id}",
     *     tags={"Job Details"},
     *     summary="Update an existing Job Detail",
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(JobDetailUpdateRequest $request, int $id)
    {
        try {
            $payload = $request->validated();

            $this->authorize('update', [JobDetail::class, $payload['workspace_id']]);

            $jobDetail = $this->jobDetailService->updateOne($id, $payload);

            return new JobDetailResource($jobDetail);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
