<?php

namespace Sprocketbox\Articulate\Contracts;

interface Attribute
{
    public function cast($value);

    public function parse($value);

    public function getColumnName(): string;

    public function getName(): string;

    public function getDefault();

    public function generate(array $attributes);

    public function isImmutable(): bool;

    public function isDynamic(): bool;

    public function isComponent(): bool;

    public function getComponent(): ?string;
}