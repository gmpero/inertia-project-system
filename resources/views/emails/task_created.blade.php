@component('mail::message')
    # Новая задача: {{ $task->title }}

    **Проект:** {{ $task->project?->title ?? 'Без проекта' }}
    **Приоритет:** {{ $task->priority?->name ?? 'Не указан' }}
    **Срок:** {{ $task->deadline?->format('d.m.Y') ?? 'Не указан' }}
    **Исполнитель:** {{ $contractor->name }}

    **Описание:**
    {{ strip_tags($task->description) }}  {{-- Удаляем HTML-теги --}}

    @component('mail::button', ['url' => route('task.show', $task->id)])
        Перейти к задаче
    @endcomponent

    С уважением,
    {{ $creator->name }} ({{ $creator->email }})
@endcomponent
