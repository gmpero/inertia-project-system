<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{project.title}}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="project">
                    <div class="mt-8 pt-8 border-t border-gray-300">
                        <div>id: {{ project.id }}</div>
                        <div>title: {{ project.title }}</div>
                        <div>description: {{ project.description }}</div>
                        <div class="text-sm text-right">created_at: {{ project.date }}</div>
                    </div>
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
