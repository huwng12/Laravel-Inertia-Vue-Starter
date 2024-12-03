<script setup>
import PaginationLinks from '../../Components/PaginationLinks.vue';
import SessionMessages from '../../Components/SessionMessages.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categoryList: Object,
    status: String
});
console.log(props.categoryList);

const activeCategory = (category) => {
    router.put(route('category.active', category.id));
}

const deleteCategory = (category) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('category.delete', category.id));
    }
}
</script>

<template>

    <Head title="- Category List" />
    <SessionMessages :status="props.status" />
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-300">Category</h1>
        <Link :href="route('category.create')"
            class="bg-slate-300 rounded-lg p-2 text-indigo-500 font-bold hover:bg-slate-400">
        Create
        Category</Link>
    </div>

    <table class="bg-white dark:bg-slate-800 w-full rounded-lg ring-1 ring-slate-300 overflow-hidden">
        <thead class="bg-slate-600 text-slate-300 uppercase">
            <tr>
                <th class="w-2/4 px-3 py-2 text-left">Category Name</th>
                <th class="w-1/4 px-3 py-2 text-center">Active</th>
                <!-- <th class="w-1/8 px-3 py-2">Listings</th> -->
                <th class="w-1/8 px-3 py-2">Delete</th>
            </tr>
        </thead>
        <tbody v-if="categoryList.data.length" class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="category in props.categoryList.data" :key="category.id">
                <td class="w-2/4 px-3 py-4 text-left">{{ category.name }}</td>
                <td class="w-1/4 px-3 py-4 text-2xl text-center">
                    <button @click.prevent="activeCategory(category)">
                        <i :class="`fa-solid fa-${category.status == 1 ? 'circle-check text-green-500'
                            : 'circle-xmark text-red-500'}`"></i>
                    </button>
                </td>
                <!-- <td class="w-1/4 px-3 py-2 text-center text-indigo-500">
                    <i class="fa-solid fa-up-right-from-square"></i>
                </td> -->
                <td class="w-1/4 px-3 py-4 text-2xl text-center">
                    <button @click.prevent="deleteCategory(category)">
                        <a class="text-link text-red-500 text-sm ">Delete</a>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <PaginationLinks class="mt-6" :paginator="categoryList" />
</template>