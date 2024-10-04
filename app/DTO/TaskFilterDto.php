<?php

namespace App\DTO;

class TaskFilterDto
{
    public ?string $search = null;
    public ?string $status = null;
    public ?int $category_id = null;

    public function __construct(
        ?string $search = null,
        ?string $status = null,
        ?int $category_id = null,
    ) {
        $this->search = $search;
        $this->status = $status;
        $this->category_id = $category_id;
    }

    public static function fromRequest($request): TaskFilterDto
    {
        return new self(
            $request->input('search'), // Use input() method
            $request->input('status'),
            $request->input('category_id'),
        );
    }

    public static function fromLivewire($component): TaskFilterDto
    {
        return new self(
            $component->search,
            $component->status,
            $component->category_id,
        );
    }
}
