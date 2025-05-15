<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Задача {{ task.task_code }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-2">
                    <h1>Show</h1>
                </div>
                <div class="ml-auto block"> <!-- или просто удалите ml-auto, т.к. justify-between уже выравнивает -->
                    <Link :href="route('task.index')" class="hover:bg-white hover:text-sky-500">Назад</Link>
                </div>
                <div v-if="task">
                    <div class="mt-8 pt-8 border-t border-gray-300">
                        <div>id: {{ task.id }}</div>
                        <div>title: {{ task.title }}</div>
                        <div v-html="task.description"></div>
                        <div class="text-sm text-right">created_at: {{ task.date }}</div>
                    </div>
                </div>
                <div class="mt-10">
                    <!-- Компонент списка сообщений -->
                    <MessageList :messages="task.messages"/>
                    <MessageForm :task-id="task.id" class="mb-8"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MessageForm from '../Task/Partials/MessageForm.vue'
import MessageList from '../Task/Partials/MessageList.vue'

export default {
    name: "Index",

    props: [
        'task'
    ],

    components: {
        Link,
        MessageForm,
        MessageList,
        AuthenticatedLayout,
    }
}
</script>

<style scoped>

</style>
