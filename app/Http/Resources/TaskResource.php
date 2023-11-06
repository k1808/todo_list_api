<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'priority'=>$this->priority,
            'status'=>$this->status?'done':'todo',
            'description'=>$this->description,
            'user'=>$this->author->name,
            'completedAt'=>$this->completedAt
        ];
    }
}
