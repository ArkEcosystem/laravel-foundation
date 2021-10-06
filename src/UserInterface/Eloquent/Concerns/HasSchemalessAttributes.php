<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * @property SchemalessAttributes $extra_attributes
 */
trait HasSchemalessAttributes
{
    /**
     * Scope the query to include the meta attributes.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    /**
     * Get the meta attribute for the model.
     *
     * @param string|array|null $name
     * @param mixed             $default
     *
     * @return mixed
     */
    public function getMetaAttribute(string | array | null $name, $default = null)
    {
        return $this->extra_attributes->get($name, $default);
    }

    /**
     * Set the meta attribute for the model.
     *
     * @param string|array $name
     * @param mixed        $value
     *
     * @return self
     */
    public function setMetaAttribute(string | array $name, $value): self
    {
        $this->extra_attributes->set($name, $value);

        return tap($this)->save();
    }

    /**
     * Determine whether the model contains a given meta attribute.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMetaAttribute(string $name): bool
    {
        return $this->extra_attributes->get($name) !== null;
    }

    /**
     * Remove the meta attribute for the model.
     *
     * @param string $name
     *
     * @return self
     */
    public function forgetMetaAttribute(string $name): self
    {
        $this->extra_attributes->forget($name);

        return tap($this)->save();
    }

    /**
     * Fill the model's meta attributes.
     *
     * @param array $attributes
     *
     * @return self
     */
    public function fillMetaAttributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->extra_attributes->set($name, $value);
        }

        return tap($this)->save();
    }

    /**
     * Update or create model with the schemaless attributes.
     *
     * @param array $attributes
     * @param array $values
     *
     * @return self
     */
    public static function updateOrCreateWithMeta(array $attributes, array $values): self
    {
        $model = static::withExtraAttributes($attributes)->first();

        if ($model) {
            $model->update($values);
        } else {
            $model = static::create($values);
        }

        return $model->fresh();
    }
}
