<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const emit = defineEmits(['categoryId']);
const props = defineProps({
    label: String,
    categories: Array,
    categoryId: Number
})
const form = useForm({
    category_id: props.categoryId,
})

watch(() => form.category_id, (value) => {
    emit('categoryId', value);
})
</script>

<template>
    <div class="flex items-center gap-2">
        <label :for="label" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ label }}
        </label>
        <select v-model="form.category_id" :id="label"
            class="text-slate-800 bg-slate-200 border-0 outline-0 rounded-lg text-sm py-1">
            <option v-for="(category, index) in categories" :key="index" :value="category.id">
                {{ category.name }}
            </option>
        </select>
    </div>
</template>