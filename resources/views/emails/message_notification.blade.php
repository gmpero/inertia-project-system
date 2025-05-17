@component('mail::message')
    # Новое сообщение в задаче: {{ $task->title }}

    **От:** {{ $message->user->name }}

    **Сообщение:**
    {{ $message->message }}

    @component('mail::button', ['url' => $taskUrl])
        Перейти к задаче
    @endcomponent

    @component('mail::panel')
        Это письмо отправлено автоматически. Пожалуйста, не отвечайте на него.
    @endcomponent

    С уважением,
    Система Управления Проектами СУП
@endcomponent
