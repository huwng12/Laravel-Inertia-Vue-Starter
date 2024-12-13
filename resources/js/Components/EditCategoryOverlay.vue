<script setup>
import Container from './Container.vue';
import Title from './Title.vue';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['category']);
const emit = defineEmits(['closeEditOverlay', 'updateCategory']);
const updateCategoryName = ref(props.category.name);

const updateCategory = () => {
    router.put(route('category.edit', props.category.id), { name: updateCategoryName.value }, {
        onSuccess: () => {
            emit('updateCategory', { id: props.category.id, name: updateCategoryName.value });
            emit('closeEditOverlay'); // Đóng overlay sau khi cập nhật thành công
        },
        onError: (errors) => {
            console.error(errors); // In lỗi nếu có
        }
    });
}

</script>

<template>
    <div class="fixed z-50 top-0 left-0 w-full h-screen bg-black bg-opacity-60 p-3">
        <button class="absolute right-3 text-white text-lg font-bold" @click="$event => $emit('closeEditOverlay')">
            X
        </button>

        <Container class="max-w-2xl mx-auto mt-60">
            <Title>Edit Category</Title>
            <form @submit.prevent="updateCategory">
                <div class="flex flex-col gap-4">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" v-model="updateCategoryName"
                        class="border border-gray-300 rounded-md p-2 dark:text-black">
                </div>
                <div class="flex justify-end gap-4 mt-4">
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Update</button>
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md"
                        @click="$event => $emit('closeEditOverlay')">Cancel</button>
                </div>
            </form>
        </Container>
    </div>
</template>