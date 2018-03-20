<?php

namespace Ollieread\Articulate\Contracts;

interface Entity
{
    /**
     * @param string $attribute
     * @param        $value
     */
    public function set(string $attribute, $value): void;

    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function get(string $attribute);

    /**
     * @param null|string $column
     *
     * @return bool
     */
    public function isDirty(?string $column = null): bool;

    /**
     *
     */
    public function clean(): void;
}