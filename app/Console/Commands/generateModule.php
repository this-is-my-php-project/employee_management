<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class GenerateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:gen {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a crud module';

    private $disk;
    private $moduleDirectoryName = 'Modules';
    private $serviceNameSuffix = 'Service';
    private $repositoryNameSuffix = 'Repository';
    private $requestNameSuffix = 'Request';
    private $resourceNameSuffix = 'Resource';
    private $modelNameSuffix = '';
    private $controllerNameSuffix = 'Controller';
    private $resourcesDirectoryName = 'Resources';
    private $requestsDirectoryName = 'Requests';
    private $policyNameSuffix = 'Policy';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->disk = Storage::createLocalDriver(['root' => app_path()]);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = $this->getModuleName();
        $modulePath = $this->moduleDirectoryName . DIRECTORY_SEPARATOR . $moduleName;
        if ($this->disk->exists($modulePath)) {
            $this->error('Module already exists');
            return 0;
        }

        try {
            $this->disk->makeDirectory($modulePath);
            $this->makeModelClass($modulePath);
            $this->makeControllerClass($modulePath);
            $this->makeRepositoryClass($modulePath);
            $this->makeServiceClass($modulePath);
            $this->makeResourceClass($modulePath);
            $this->makePolicyClass($modulePath);
            $this->makeRequestClass($modulePath);
            $this->info('Module ' . $moduleName . ' created successfully!');
        } catch (\Exception $e) {
            $this->disk->deleteDirectory($modulePath);
            $this->error('Failed to create module');
            $this->line($e->getMessage());
        }
    }

    public function makeControllerClass($path)
    {
        $moduleName = $this->getModuleName();
        $moduleNameCamelCase = Str::camel($moduleName);
        $moduleTitle = $this->getModuleTitle();
        $modelName = $this->getModelName();
        $controllerName = $this->getControllerName();
        $routeParameterName = Str::snake($moduleName);
        $serviceName = $this->getServiceName();
        $resourceName = $this->getResourceName();
        $serviceNameCamelCase = Str::camel($serviceName);
        $pluralModuleTitle = Str::plural($moduleTitle);
        $pluralModuleNameCamelCase = Str::camel($pluralModuleTitle);
        $moduleUrlPath = Str::slug($pluralModuleTitle);
        $indexRequestName = $this->getIndexRequestName();
        $storeRequestName = $this->getStoreRequestName();
        $updateRequestName = $this->getUpdateRequestName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Http\Controllers\Controller;
        use App\\$this->moduleDirectoryName\\$moduleName\\$serviceName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->resourcesDirectoryName\\$resourceName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName\\$storeRequestName;
        use App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName\\$updateRequestName;
        use Illuminate\Http\Request;

        class $controllerName extends Controller
        {
            protected \$$serviceNameCamelCase;

            public function __construct($serviceName \$$serviceNameCamelCase)
            {
                \$this->middleware('auth');
                \$this->$serviceNameCamelCase = \$$serviceNameCamelCase;
            }

            /**
             * @OA\GET(
             *     path="/api/$moduleUrlPath",
             *     tags={"$pluralModuleTitle"},
             *     summary="Get $pluralModuleTitle list",
             *     description="Get $pluralModuleTitle List as Array",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function index(Request \$request)
            {
                try {
                    \$this->authorize('viewAny', $modelName::class);
                    
                    \$$pluralModuleNameCamelCase = \$this->{$serviceNameCamelCase}->paginate(\$request->all());
                    return $resourceName::collection(\$$pluralModuleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }

            /**
             * @OA\GET(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Get $moduleTitle detail",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function show(Request \$request, int \$id)
            {
                try {
                    \$this->authorize('view', $modelName::class);

                    \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->getOneOrFail(\$id, \$request->all());
                    return new $resourceName(\$$moduleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }

            /**
             * @OA\POST(
             *     path="/api/$moduleUrlPath",
             *     tags={"$pluralModuleTitle"},
             *     summary="Create a new $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=422, description="Unprocessable Entity"),
             * )
             */
            public function store($storeRequestName \$request)
            {
                try {
                    \$this->authorize('create', $modelName::class);

                    \$payload = \$request->validated();
                    \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->createOne(\$payload);

                    return new $resourceName(\$$moduleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }

            /**
             * @OA\PUT(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Update an existing $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=422, description="Unprocessable Entity"),
             * )
             */
            public function update($updateRequestName \$request, int \$id)
            {
                try {
                    \$this->authorize('update', $modelName::class);

                    \$payload = \$request->validated();
                    \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->updateOne(\$id, \$payload);

                    return new $resourceName(\$$moduleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }

            /**
             * @OA\DELETE(
             *     path="/api/$moduleUrlPath/{id}",
             *     tags={"$pluralModuleTitle"},
             *     summary="Delete a $moduleTitle",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function destroy(int \$id)
            {
                try {
                    \$this->authorize('delete', $modelName::class);

                    \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->deleteOne(\$id);
                    return new $resourceName(\$$moduleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }

            /**
             * @OA\POST(
             *     path="/api/$moduleUrlPath/{id}/restore",
             *     tags={"$pluralModuleTitle"},
             *     summary="Restore a $moduleTitle from trash",
             *     @OA\Response(response=400, description="Bad request"),
             *     @OA\Response(response=404, description="Resource Not Found"),
             * )
             */
            public function restore(int \$id)
            {
                try {
                    \$this->authorize('restore', $modelName::class);

                    \$$moduleNameCamelCase = \$this->{$serviceNameCamelCase}->restoreOne(\$id);
                    return new $resourceName(\$$moduleNameCamelCase);
                } catch (\Exception \$e) {
                    return \$this->sendError(\$e->getMessage());
                }
            }
        }

        XML;
        $this->disk->put($path . '/' . $controllerName . '.php', $content);
    }

    public function makeRepositoryClass($path)
    {
        $moduleName = $this->getModuleName();
        $modelName = $this->getModelName();
        $modelNameCamelCase = Str::camel($modelName);
        $repositoryName = $this->getRepositoryName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Libraries\Crud\BaseRepository;
        use App\\$this->moduleDirectoryName\\$moduleName\\$modelName;

        class $repositoryName extends BaseRepository
        {
            public function __construct($modelName \$$modelNameCamelCase)
            {
                parent::__construct(\$$modelNameCamelCase);
            }
        }
        
        XML;

        $this->disk->put($path . '/' . $repositoryName . '.php', $content);
        $this->info('- Repository');
    }

    public function makeServiceClass($path)
    {
        $moduleName = $this->getModuleName();
        $repositoryName = $this->getRepositoryName();
        $serviceName = $this->getServiceName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\Libraries\Crud\BaseService;

        class $serviceName extends BaseService
        {
            protected array \$allowedRelations = [];

            public function __construct($repositoryName \$repo)
            {
                parent::__construct(\$repo);
            }
        }
        
        XML;

        $this->disk->put($path . '/' . $serviceName . '.php', $content);
        $this->info('- Service');
    }

    public function makeModelClass($path)
    {
        $moduleName = $this->getModuleName();
        $modelName = $this->getModelName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Laravel\Passport\HasApiTokens;
        use Illuminate\Notifications\Notifiable;
        use Illuminate\Database\Eloquent\SoftDeletes;

        class $modelName extends Model
        {
            use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
        }
        
        XML;

        $this->disk->put($path . '/' . $modelName . '.php', $content);
        $this->info('- Model');
    }

    public function makeResourceClass($path)
    {
        $moduleName = $this->getModuleName();
        $resourceName = $this->getResourceName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->resourcesDirectoryName;

        use Illuminate\Http\Resources\Json\JsonResource;

        class $resourceName extends JsonResource
        {
            /**
             * Transform the resource into an array.
             *
             * @param  \Illuminate\Http\Request  \$request
             * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
             */
            public function toArray(\$request)
            {
                return parent::toArray(\$request);
            }
        }
        
        XML;

        $filePath = $path . '/' . $this->resourcesDirectoryName . '/' . $resourceName . '.php';
        $this->disk->put($filePath, $content);
        $this->info('- Resource');
    }

    public function makeRequestClass($path)
    {
        //$this->makeIndexRequestClass($path);
        $this->makeStoreDataRequestClass($path);
        $this->makeUpdateDataRequestClass($path);
    }

    public function makeUpdateDataRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $className = $this->getUpdateRequestName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        use App\Libraries\Crud\BaseRequest;

        class $className extends BaseRequest
        {
            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    //  
                ];
            }
        }
        
        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $className . '.php';
        $this->disk->put($filePath, $content);
        $this->info('- Update Request');
    }

    public function makeIndexRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $requestName = $this->getIndexRequestName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        use App\Libraries\Crud\BaseRequest;

        class $requestName extends BaseRequest
        {
            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    //
                ];
            }
        }
        
        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $requestName . '.php';
        $this->disk->put($filePath, $content);
        $this->info('- Index Request');
    }

    public function makeStoreDataRequestClass($path)
    {
        $moduleName = $this->getModuleName();
        $className = $this->getStoreRequestName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName\\$this->requestsDirectoryName;

        use App\Libraries\Crud\BaseRequest;

        class $className extends BaseRequest
        {
            /**
             * Get the validation rules that apply to the request.
             *
             * @return array
             */
            public function rules()
            {
                return [
                    //
                ];
            }
        }
        
        XML;

        $filePath = $path . '/' . $this->requestsDirectoryName . '/' . $className . '.php';
        $this->disk->put($filePath, $content);
        $this->info('- Store Request');
    }

    public function makePolicyClass($path)
    {
        $moduleName = $this->getModuleName();
        $moduleTitle = $this->getModuleTitle();
        $modelName = $this->getModelName();
        $policyName = $this->getPolicyName();

        $content = <<<XML
        <?php

        namespace App\\$this->moduleDirectoryName\\$moduleName;

        use App\\$this->moduleDirectoryName\User\User;
        use Illuminate\Auth\Access\HandlesAuthorization;
        use App\\$this->moduleDirectoryName\Permission\Enum\Permission;

        class $policyName
        {
            use HandlesAuthorization;

            /**
             * Determine whether the user can view any $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function viewAny(User \$user)
            {
                // return \$user->can(Permission::VIEW_USER);
                return true;
            }

            /**
             * Determine whether the user can view the $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function view(User \$user)
            {
                // return \$user->can(Permission::VIEW_USER->value);
                return true;
            }

            /**
             * Determine whether the user can create $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function create(User \$user)
            {
                // return \$user->can(Permission::CREATE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can update the $moduleTitle.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function update(User \$user)
            {
                // return \$user->can(Permission::UPDATE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can delete the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function delete(User \$user)
            {
                // return \$user->can(Permission::DELETE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can restore the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function restore(User \$user)
            {
                // return \$user->can(Permission::RESTORE_USER->value);
                return true;
            }

            /**
             * Determine whether the user can permanently delete the $modelName.
             *
             * @param  \App\\$this->moduleDirectoryName\User\User  \$user
             * @return \Illuminate\Auth\Access\Response|bool
             */
            public function forceDelete(User \$user)
            {
                // return \$user->can(Permission::FORCE_DELETE_USER->value);
                return true;
            }
        }

        XML;

        $filePath = $path . '/' . $policyName . '.php';
        $this->disk->put($filePath, $content);
        $this->info('- Policy');
    }

    public function getModuleName()
    {
        return ucwords($this->argument('module'));
    }

    public function getModuleTitle()
    {
        return Str::title(
            Str::replace('_', ' ', Str::of($this->argument('module'))->snake())
        );
    }

    public function getControllerName()
    {
        return $this->getModuleName() . $this->controllerNameSuffix;
    }

    public function getModelName()
    {
        return $this->getModuleName() . $this->modelNameSuffix;
    }

    public function getServiceName()
    {
        return $this->getModuleName() . $this->serviceNameSuffix;
    }

    public function getRepositoryName()
    {
        return $this->getModuleName() . $this->repositoryNameSuffix;
    }

    public function getIndexRequestName()
    {
        return $this->getModuleName() . 'Index' . $this->requestNameSuffix;
    }

    public function getStoreRequestName()
    {
        return $this->getModuleName() . 'Store' . $this->requestNameSuffix;
    }

    public function getUpdateRequestName()
    {
        return  $this->getModuleName() . 'Update' . $this->requestNameSuffix;
    }

    public function getResourceName()
    {
        return $this->getModuleName() . $this->resourceNameSuffix;
    }

    public function getPolicyName()
    {
        return $this->getModuleName() . $this->policyNameSuffix;
    }
}
