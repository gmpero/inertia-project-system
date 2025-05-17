<?php

namespace App\Http\Resources\Task;

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
            'id' => $this->id,
            'task_code' => $this->task_code,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->created_at->format('d.m.Y H:i:s'),
            'project' => [
                'id' => $this->project->id,
                'title' => $this->project->title,
            ],
            'creator' => $this->whenLoaded('creator'),
            'contractor' => $this->whenLoaded('contractor'),
            'priority' => $this->whenLoaded('priority'),
            'messages' => $this->whenLoaded('messages'),
            'files' => $this->when($this->files, function() {
                return array_map(function($file) {
                    $file['url'] = asset('storage/'.$file['path']);
                    return $file;
                }, $this->files);
            }),
//            'date' => $this->created_at->diffForHumans(),
        ];
    }
}
