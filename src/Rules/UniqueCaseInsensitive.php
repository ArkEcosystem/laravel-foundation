<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

final class UniqueCaseInsensitive implements Rule
{
    protected Model $model;

    protected string $field;

    protected ?string $except = null;

    protected bool $withTrashed = false;

    public function __construct(string $model, string $field)
    {
        $this->model  = new $model();
        $this->field  = $field;
    }

    public function except(string $except): self
    {
        $this->except = $except;

        return $this;
    }

    public function withTrashed(): self
    {
        $this->withTrashed = true;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $query = $this->model->where(DB::raw('UPPER('.$this->field.')'), strtoupper($value));

        if ($this->except !== null) {
            $query->where($this->field, '!=', $this->except);
        }

        if ($this->withTrashed && method_exists($this->model, 'isForceDeleting')) {
            $query->withTrashed();
        }

        return ! $query->exists();
    }

    public function message()
    {
        return trans('validation.messages.unique_case_insensitive');
    }
}
