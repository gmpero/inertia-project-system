<template>
    <AuthenticatedLayout>
        <div class="w-3/6 mx-auto pt-8 mb-8"> <!-- Добавлены flex и justify-between -->
            <div class="mb-2">
                <h1>Show</h1>
            </div>
            <div class="ml-auto block"> <!-- или просто удалите ml-auto, т.к. justify-between уже выравнивает -->
                <Link :href="route('project.index')" class="hover:bg-white hover:text-sky-500">Назад</Link>
            </div>
            <div v-if="project">
                <div class="mt-8 pt-8 border-t border-gray-300">
                    <div>id: {{ project.id }}</div>
                    <div>title: {{ project.title }}</div>
                    <div>description: {{ project.description }}</div>
                    <div class="text-sm text-right">created_at: {{ project.date }}</div>
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

    props: [
        'project'
    ],

    components: {
        Link,
        AuthenticatedLayout,
    }
}
</script>

<style scoped>

</style>
