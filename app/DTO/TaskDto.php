<?php

namespace App\DTO;

class TaskDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public int $categoryId,
        public string $status,
    ) {}

    public static function fromRequest($request)
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
            categoryId: $request->input('category_id'),
            status: $request->input('status') ?? 'New', // Default to 'New' if not provided
        );
    }
}
