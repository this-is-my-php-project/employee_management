<?php

namespace App\Modules\Profile;

use App\Libraries\Crud\BaseService;
use App\Modules\JobDetail\JobDetailService;
use Illuminate\Support\Facades\DB;

class ProfileService extends BaseService
{
    protected array $allowedRelations = [
        'user',
        'workspace',
        'jobDetail',
    ];

    protected JobDetailService $jobDetailService;

    public function __construct(
        ProfileRepository $repo,
        JobDetailService $jobDetailService
    ) {
        parent::__construct($repo);
        $this->jobDetailService = $jobDetailService;
    }

    /**
     * Create default profile for user
     *
     * @param array $user
     * @param int $workspaceId
     * @return Profile
     */
    public function createDefault(array $user, int $workspaceId): Profile
    {
        return $this->repo->createOne([
            'name' => $user['name'],
            'alias' => '',
            'avatar' => $user['avatar'] ?? null,
            'phone' => $user['phone'] ?? null,
            'email' => $user['email'] ?? null,
            'user_id' => $user['id'],
            'workspace_id' => $workspaceId,
        ]);
    }

    public function deleteOne(string|int $id): ?Profile
    {
        return DB::transaction(function () use ($id) {
            $profile = $this->getOneOrFail($id);

            $jobDetailId = $profile->jobDetail->id;

            $profile = $this->repo->deleteOne($profile);

            $this->jobDetailService->deleteOne($jobDetailId);

            return $profile;
        });
    }
}
