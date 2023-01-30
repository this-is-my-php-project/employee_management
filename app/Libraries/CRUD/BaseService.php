<?php

namespace App\Libraries\CRUD;

use Illuminate\Http\Response;
use App\Libraries\CRUD\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;
use DateTimeZone;

class BaseService
{
    // Repository class that used for this service
    protected BaseRepository $repo;

    // Filters that used for each query
    protected Collection $filters;

    // Limit per page used for pagination
    protected int $limit = 50;

    // Only relations defined is allowed
    protected array $allowedRelations = [];

    // Only relations defined is allowed to used for filters
    protected array $filterable = [];

    // Sort columns: eg: id => desc, name => asc
    protected array $sorts = [];

    // Path that used for image uploading
    protected string $uploadPath = '';

    // Disk that it uploads image to
    protected string $uploadDisk = 'public';

    // Available filter operators
    private array $allowedOperators = [
        '=', '>', '<', '>=', '<=', 'like', 'contain', 'between', 'date', 'exists'
    ];

    /**
     * Constructor of BaseService
     */
    public function __construct(BaseRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get current date time
     */
    public function getCurrentDateTime($timeZone = 'Asia/Phnom_Penh')
    {
        $now = new DateTime('now', new DateTimeZone($timeZone));
        return $now->format('Y-m-d H:i:s');
    }

    /**
     * Event to run before each query executes
     *
     * @return callable
     */
    public function onBeforeQuery(): ?callable
    {
        return null;
    }

    /**
     * Get relations from request
     * 
     * @param array $options
     * @return array
     */
    public function getRelations(array $options): array
    {
        $relations = $options['relations'] ?? [];

        if (!is_string($relations)) {
            abort(Response::HTTP_BAD_REQUEST, 'Relations must be string');
        }

        $relations = explode(',', $relations);

        return array_intersect($relations, $this->allowedRelations);
    }

    /**
     * Get sorts from request
     *
     * @param array $options
     * @return array
     */
    public function getSorts(array $options): array
    {
        if (empty($options['sorts'])) {
            return [];
        }

        $sorts = explode(',', $options['sorts']);
        $result = [];

        // Transform format column:desc to array format [column => desc]
        foreach ($sorts as $sort) {
            $sortOption = explode(':', $sort);
            if (!empty($sortOption[1])) {
                $result[$sortOption[0]] = $sortOption[1];
            }
        }

        return $result;
    }

    /**
     * Set filters from request
     * 
     * 
     * 
     * @param array $options
     * @return void
     */
    public function setFilters(array $options)
    {
        $filters = $options['filters'] ?? [];

        foreach ($filters as $filter) {
            if (count($filter) < 3) {
                abort(Response::HTTP_BAD_REQUEST, 'Invalid filter format');
            }

            ['field' => $field, 'operator' => $operator, 'value' => $value] = $filter;

            if (!in_array($operator, $this->allowedOperators)) {
                abort(Response::HTTP_BAD_REQUEST, 'Invalid filter operator');
            }

            if (!in_array($field, $this->filterable)) {
                abort(Response::HTTP_BAD_REQUEST, 'Invalid filter field');
            }
        }

        return $filters;
    }

    /**
     * Prepare options for query
     * 
     * @param array $options
     * @return array
     */
    public function prepareOptions(?array $options = null): array
    {
        if (empty($options)) {
            return [
                'filters' => [],
                'relations' => [],
                'fields' => ['*'],
                'page' => 1,
                'limit' => $this->limit,
                'sorts' => [],
                'search' => null,
                'search_fields' => [],
            ];
        }

        return [
            'filters' => $this->setFilters($options),
            'relations' => !empty($options['relations']) ? $this->getRelations($options) : [],
            'fields' => $options['fields'] ?? ['*'],
            'page' => $options['page'] ?? 1,
            'limit' => $options['limit'] ?? $this->limit,
            'search' => $options['search'] ?? null,
            'sorts' => $this->getSorts($options),
            'search_fields' => $options['search_fields'] ?? [],
        ];
    }

    /**
     * Get records into pagination
     *
     * @param array $options
     * @return Collection|LengthAwarePaginator
     */
    public function paginate(?array $options = null): Collection|LengthAwarePaginator
    {
        if ($options['no_pagination'] ?? null) {
            return $this->getMany($options);
        }

        return $this->repo->paginate(
            $this->prepareOptions($options),
            $this->onBeforeQuery()
        );
    }

    /**
     * Get records including items in trash into pagination
     *
     * @param array $options
     * @return Collection|LengthAwarePaginator
     */
    public function paginateWithTrashed(?array $options = null): Collection|LengthAwarePaginator
    {
        if ($options['no_pagination'] ?? null) {
            return $this->getMany($options);
        }

        return $this->repo->paginateWithTrashed(
            $this->prepareOptions($options),
            $this->onBeforeQuery()
        );
    }

    /**
     * Get records only items in trash into pagination
     *
     * @param array $options
     * @return Collection|LengthAwarePaginator
     */
    public function paginateFromTrash(?array $options = null): Collection|LengthAwarePaginator
    {
        if ($options['no_pagination'] ?? null) {
            return $this->getManyFromTrash($options);
        }

        return $this->repo->paginateFromTrash(
            $this->prepareOptions($options),
            $this->onBeforeQuery()
        );
    }

    /**
     * Get all records
     *
     * @param array $options
     * @return Collection
     */
    public function getMany(?array $options = null): Collection
    {
        return $this->repo->getMany($this->prepareOptions($options), $this->onBeforeQuery());
    }

    /**
     * Get all records
     *
     * @param array $options
     * @return Collection
     */
    public function getManyWithTrashed(?array $options = null): Collection
    {
        [$filters, $relations, $pageOptions, $fields] = $this->prepareOptions($options);
        return $this->repo->getManyWithTrashed($filters, $relations, $pageOptions, $fields);
    }

    /**
     * Get all records
     *
     * @param array $options
     * @return Collection
     */
    public function getManyFromTrash(?array $options = null): Collection
    {
        $options = $this->prepareOptions($options);
        return $this->repo->getManyFromTrash($options);
    }

    /**
     * Get one record which is not deleted by specified field (default = "id")
     *
     * @param mixed|null $id
     * @param null|array $options
     * @return null|Model
     */
    public function getOne(mixed $id, ?array $options = null): ?Model
    {
        $options = $this->prepareOptions($options);
        return $this->repo->getOne($id, $options);
    }

    /**
     * Get one record or return 404 if record is not found
     *
     * @param mixed|null $id
     * @param null|array $options
     * @return null|Model
     */
    public function getOneOrFail(mixed $id, ?array $options = null): ?Model
    {
        $options = $this->prepareOptions($options);
        return $this->repo->getOneOrFail($id, $options, $this->onBeforeQuery());
    }

    /**
     * Get one record by specified field (default = "id")
     *
     * @param mixed|null $id
     * @param null|array $options
     * @return null|Model|Builder|QueryBuilder
     */
    public function getOneWithTrashed(mixed $id, ?array $options = null): ?Model
    {
        $options = $this->prepareOptions($options);
        return $this->repo->getOneWithTrashed($id, $options, $this->onBeforeQuery());
    }

    /**
     * Get one record by specified field (default = "id")
     *
     * @param mixed|null $id
     * @param null|array $options
     * @return null|Model|Builder|QueryBuilder
     */
    public function getOneFromTrashed(mixed $id, ?array $options = null): ?Model
    {
        $options = $this->prepareOptions($options);
        return $this->repo->getOneFromTrash($id, $options, $this->onBeforeQuery());
    }

    /**
     * Create one record
     *
     * @param array $payload
     * @return null|Model
     */
    public function createOne(array $payload): ?Model
    {
        return $this->repo->createOne($payload);
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|Model
     */
    public function updateOne(string|int $id, array $payload): ?Model
    {
        $record = $this->repo->getOneOrFail($id);
        return $this->repo->updateOne($record, $payload);
    }

    /**
     * Update one record
     *
     * @param Model $model
     * @param array $payload
     * @return null|Model
     */
    public function updateModel(Model $model, array $payload): ?Model
    {
        return $this->repo->updateOne($model, $payload);
    }

    /**
     * Delete one record
     *
     * @param string|int $id
     * @return null|Model
     */
    public function deleteOne(string|int $id): ?Model
    {
        $record = $this->getOneOrFail($id);
        return $this->repo->deleteOne($record);
    }

    /**
     * Delete one record by model
     *
     * @param Model $model
     * @return null|Model
     */
    public function deleteModel(Model $model): ?Model
    {
        return $this->repo->deleteOne($model);
    }

    /**
     * Restore one record from trash
     *
     * @param string|int $id
     * @return null|Model
     */
    public function restoreOne(string|int $id): ?Model
    {
        $record = $this->repo->getOneFromTrash($id);
        !$record && abort(404);
        return $this->repo->restoreOne($record);
    }

    /**
     * Delete one record from trash by model
     *
     * @param Model $model
     * @return null|Model
     */
    public function restoreModel(Model $model): ?Model
    {
        return $this->repo->restoreOne($model);
    }

    /**
     * Force delete one record
     *
     * @param string|int $id
     * @return null|Model
     */
    public function forceDeleteOne(string|int $id): ?Model
    {
        $record = $this->getOneOrFail($id);
        return $this->repo->forceDeleteOne($record);
    }

    /**
     * Force delete one record
     *
     * @param Model $model
     * @return null|Model
     */
    public function forceDeleteModel(Model $model): ?Model
    {
        return $this->repo->forceDeleteOne($model);
    }

    /**
     * @param callable $where
     * @return null|int
     */
    public function countWhere(callable $where): ?int
    {
        [$filters] = $this->prepareOptions([]);
        return $this->repo->countWhere($where, compact('filters'));
    }
}
