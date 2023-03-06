<?php

namespace App\Libraries\CRUD;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseRepository
{
    /**
     * @var int
     */
    protected $limit = 50;

    /**
     * @var Model
     */
    protected $model;

    public function getByFields(array $fields, array $payload): ?Model
    {
        return $this->model->where($fields, $payload)->first();
    }

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function deleteMultipleByField(string $field, $value): bool
    {
        return $this->model->where($field, $value)->delete();
    }

    /**
     * Update one record
     * @param Model $model
     * @param array $payload
     * @return null|Model
     */
    public function updateOne(Model $model, array $payload)
    {
        if (!$model) {
            return null;
        }

        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * Create one record
     * @param array $payload
     * @return null|Model
     */
    public function createOne(array $payload)
    {
        $model = $this->model;
        $model->fill($payload);
        $model->save();

        return $model;
    }

    /**
     * Create many records
     * @param array $payloads
     * @return array
     */
    public function createMany(array $payloads)
    {
        $models = [];
        foreach ($payloads as $payload) {
            $models[] = $this->model->create($payload);
        }

        return $models;
    }

    /**
     * Create insert records
     * 
     * @param array $payload
     * @return bool
     */
    public function insertMany(array $payload)
    {
        return $this->model->insert($payload);
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function deleteOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        $model->delete();

        return $model;
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function restoreOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        $model->restore();

        return $model;
    }

    /**
     * @param Model $model
     * @return null|Model
     */
    public function forceDeleteOne(Model $model): ?Model
    {
        if (!$model) {
            return null;
        }

        return $this->model->forceDelete($model);
    }

    /**
     * @param array|callable $where
     * @return int|null
     */
    public function countWhere(array|callable $where, array $filters = []): ?int
    {
        $query = $this->buildQuery($filters, [], [], []);

        if (is_array($where)) {
            foreach ($where as $field => $value) {
                $query->where($field, $value);
            }
        }

        return $query->where($where)->count();
    }

    /**
     * @param array $options
     * @param array|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginate(array $options = [], ?callable $beforeQuery): Collection|LengthAwarePaginator
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginateWithTrashed(array $options = [], ?callable $beforeQuery = null): Collection|LengthAwarePaginator
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->withTrashed()->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection|LengthAwarePaginator
     */
    public function paginateFromTrash(array $options = [], ?callable $beforeQuery = null): Collection|LengthAwarePaginator
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->onlyTrashed()->paginate($options['limit'] ?? $this->limit);
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getMany(array $options = [], ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->limit($options['limit'] ?? $this->limit)->get();
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getManyWithTrashed(array $options = [], ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->limit($options['limit'] ?? $this->limit)->withTrashed()->get();
    }

    /**
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Collection
     */
    public function getManyFromTrash(array $options = [],  ?callable $beforeQuery = null): Collection
    {
        $query = $this->buildQuery($options);

        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }


        return $query->limit($options['limit'] ?? $this->limit)->onlyTrashed()->get();
    }

    /**
     * @param mixed|null $value
     * @param string $field
     * @param array|null $options
     * @return null|Model
     */
    public function getOne(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->find($id);
    }

    /**
     * @param mixed|null $value
     * @return null|object
     */
    public function getLatest(): ?object
    {
        return DB::table($this->model->getTable())->latest()->first();
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneOrFail(mixed $id, ?array $options = [], ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->findOrFail($id);
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneWithTrashed(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->withTrashed()->find($id);
    }

    /**
     * @param mixed $id
     * @param string $field
     * @param array $options
     * @return null|Model
     */
    public function getOneFromTrash(mixed $id, ?array $options = null, ?callable $beforeQuery = null): ?Model
    {
        $query = $this->buildQuery($options);
        if ($beforeQuery) {
            $query = $beforeQuery($query);
        }

        return $query->onlyTrashed()->find($id);
    }

    /**
     * Build eloquent query
     * @param array $options
     * @param callable|null $beforeQuery
     * @return Model|Builder|QueryBuilder
     */
    public function buildQuery(array $options = [], callable $beforeQuery = null)
    {
        if (empty($options)) {
            return $this->model;
        }

        $sorts = $options['sorts'] ?? [];
        $filters = $options['filters'] ?? [];
        $search = $options['search'] ?? '';
        $searchFields = $options['searchFields'] ?? [];
        $fields = $options['fields'] ?? [];
        $relations = $options['relations'] ?? [];
        $counts = $options['counts'] ?? [];
        $limit = $options['limit'] ?? $this->limit;

        return $this->model
            ->select($this->getSelectFields($fields))
            ->when(!empty($filters), $this->filters($filters))
            ->when($search && !empty($searchFields), $this->search($search, $searchFields))
            ->when(count($sorts) > 0, $this->sorts($sorts))
            ->limit($limit)
            ->withCount($counts)
            ->with($relations);
    }

    /**
     * if fields is empty, return all fields
     * if fields is not empty, loop through fields 
     * remove all special characters except A-Z, a-z, 0-9,
     * 
     * @param array $fields
     * @return array
     */
    public function getSelectFields(array $fields = []): array
    {
        if (empty($fields)) {
            return ['*'];
        }

        return array_map(
            fn ($field) => preg_replace('/[^a-zA-Z0-9_*]/', '', $field),
            $fields
        );
    }

    /**
     * @param array $sorts
     * @return callable
     */
    public function sorts(array $sorts = []): callable
    {
        return function (Builder $query) use ($sorts) {
            foreach ($sorts as $field => $sort) {
                $query->orderBy($field, $sort);
            }
        };
    }

    /**
     * @param array $filters
     * @return callable
     */
    public function filters(array $filters = []): callable
    {
        return function (Builder $query) use ($filters) {
            $query->where(function (Builder $query) use ($filters) {
                foreach ($filters as $fields) {
                    ['field' => $field, 'operator' => $operator, 'value' => $value] = $fields;
                    $query->where(
                        $this->isRelationField($field)
                            ? $this->whereRelation($field, $value, $operator)
                            : $this->buildFiltersQuery($field, $operator, $value)
                    );
                }
            });
        };
    }

    public function isRelationField(string $field): bool
    {
        return strpos($field, '.') !== false;
    }

    public function whereRelation(string $field, string $value, string $operator)
    {
        return function (Builder $query) use ($field, $operator, $value) {
            if ($this->isRelationField($field)) {
                $data = explode('.', $field);

                if (count($data) === 2) {
                    $relation = $data[0];
                    $relationField = $data[1];

                    $query->whereHas($relation, $this->buildFiltersQuery($relationField, $operator, $value));
                }

                if (count($data) === 3) {
                    $relation1 = $data[0];
                    $relation2 = $data[1];
                    $relationField = $data[2];

                    $query->whereHas($relation1, function (Builder $query) use ($relation2, $operator, $value, $relationField) {
                        $query->whereHas($relation2, $this->buildFiltersQuery($relationField, $operator, $value));
                    });
                }

                return $query;
            }

            return $query;
        };
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $operator
     * @return callable
     */
    public function buildFiltersQuery(mixed $field, mixed $value, mixed $operator = '=')
    {
        return function (Builder $query) use ($field, $value, $operator) {
            if ($value && (is_array($value) || $operator === 'between')) {
                if ($operator !== 'between') {
                    return $query->whereIn($field, $value);
                }

                $filteredValue = array_filter($value);
                if (count($filteredValue) === 0) {
                    return $query;
                }

                if (count($filteredValue) === 1) {
                    if (!empty($value[0])) {
                        return $query->where($field, '>=', $value[0]);
                    }

                    return $query->where($field, '<=', $value[1]);
                }

                return $query->whereBetween($field, $filteredValue);
            }

            if ($value !== null) {
                if ($operator === 'contain') {
                    return $query->where($field, 'ilike', '%' . $value . '%');
                }

                if ($operator === 'date') {
                    return $query->whereDate($field, $value);
                }

                if ($operator === 'exists') {
                    if ($value === 'true' || $value === true) {
                        return $query->whereNotNull($field);
                    }

                    return $query->whereNull($field);
                }

                return $query->where($field, $operator, $value);
            }

            return $query;
        };
    }

    /**
     * @param string $search
     * @param array $searchFields
     * @return callable
     */
    public function search(string $search, array $searchFields = []): callable
    {
        return function (Builder $query) use ($search, $searchFields) {
            $query->where(function (Builder $query) use ($search, $searchFields) {
                foreach ($searchFields as $searchField) {
                    if ($this->isRelationField($searchField)) {
                        $query->orWhere($this->whereRelation($searchField, $search, 'contain'));
                    } else {
                        $query->orWhere($searchField, 'like', '%' . $search . '%');
                    }
                }
            });
        };
    }
}
