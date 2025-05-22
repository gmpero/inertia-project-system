<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">Календарь</h2>
        </template>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <div ref="calendarEl" class="h-[600px]"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "Index",
    components: {
        Link,
        AuthenticatedLayout,
    },
    props: {
        events: Array
    },
    mounted() {
        const calendar = new FullCalendar.Calendar(this.$refs.calendarEl, {
            initialView: 'dayGridMonth',
            events: this.events,
            eventContent: (arg) => {
                const project = arg.event.extendedProps.project || 'Без проекта';
                const title = arg.event.title || 'Без названия';
                const priority = (arg.event.extendedProps.priority || 'обычный').toLowerCase();

                // Цвета для русских приоритетов
                const priorityColors = {
                    'высокий': '#ef4444',    // красный
                    'средний': '#f59e0b',    // оранжевый
                    'низкий': '#10b981',     // зеленый
                    'обычный': '#3b82f6'     // синий (по умолчанию)
                };

                // Если приоритет не найден, используем синий цвет
                const priorityColor = priorityColors[priority] || '#3b82f6';

                const container = document.createElement('div');
                container.className = 'fc-event-content';

                // Цветная полоса проекта
                const colorStrip = document.createElement('div');
                colorStrip.className = 'fc-event-color-strip';
                colorStrip.style.backgroundColor = arg.event.backgroundColor;

                // Основной контент
                const content = document.createElement('div');
                content.className = 'fc-event-main-content';

                // Первая строка: Проект | Название задачи
                const firstLine = document.createElement('div');
                firstLine.className = 'fc-event-first-line';
                firstLine.innerHTML = `
        <span class="fc-event-project">${project}</span>
        <span class="fc-event-separator">|</span>
        <span class="fc-event-title">${title}</span>
    `;

                // Вторая строка: Приоритет с цветным квадратиком
                const secondLine = document.createElement('div');
                secondLine.className = 'fc-event-second-line';
                secondLine.innerHTML = `
        <span class="fc-event-priority-dot" style="background-color: ${priorityColor}"></span>
        <span class="fc-event-priority-text">${priority}</span>
    `;

                content.appendChild(firstLine);
                content.appendChild(secondLine);
                container.appendChild(colorStrip);
                container.appendChild(content);

                return {domNodes: [container]};
            },
            eventClick: (info) => {
                // действие при клике
            }
        });
        calendar.render();
    },
    methods: {
        showEventDetails(details) {
            // ...
        }
    }
}
</script>

<style>
.fc-event {
    position: relative;
    padding: 6px 8px 6px 12px;
    overflow: hidden;
    border-radius: 4px;
    margin-bottom: 2px;
}

.fc-event-content {
    position: relative;
    display: flex;
    width: 100%;
}

.fc-event-color-strip {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    border-radius: 2px 0 0 2px;
}

.fc-event-main-content {
    margin-left: 8px;
    width: calc(100% - 8px);
}

.fc-event-first-line {
    display: flex;
    align-items: center;
    font-size: 0.85em;
    margin-bottom: 3px;
    flex-wrap: wrap;
}

.fc-event-project {
    font-weight: 600;
    margin-right: 4px;
}

.fc-event-separator {
    margin: 0 4px;
    color: #000000;
}

.fc-event-title {
    margin-right: 4px;
}

.fc-event-second-line {
    display: flex;
    align-items: center;
    font-size: 0.75em;
}

.fc-event-priority-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 2px;
    margin-right: 6px;
}

.fc-event-priority-text {
    color: #000000;
    text-transform: capitalize; /* Первая буква заглавная */
}

.fc-event-first-line {
    display: flex;
    align-items: center;
    font-size: 0.85em;
    margin-bottom: 3px;
    flex-wrap: wrap;
    color: #000000; /* Добавляем черный цвет для всей строки */
}

.fc-event-project {
    font-weight: 600;
    margin-right: 4px;
    color: #000000; /* Черный цвет для проекта */
}

.fc-event-separator {
    margin: 0 4px;
    color: #000000; /* Черный цвет для разделителя */
}

.fc-event-title {
    margin-right: 4px;
    color: #000000; /* Черный цвет для названия задачи */
}
</style>
