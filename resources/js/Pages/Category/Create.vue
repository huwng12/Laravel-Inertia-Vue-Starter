<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import InputField from '../../Components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import ImageUpload from '../../Components/ImageUpload.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';

const form = useForm({
    'name': ''
})
</script>

<template>

    <Head title="- New Category" />

    <Container>
        <div class="mb-6">
            <Title>Create new category</Title>
        </div>
        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="form.post(route('category.store'))">
            <div class="space-y-6 mb-6">
                <InputField label="Category Name" icon="font" placeholder="My category" v-model="form.name" />
            </div>

            <div>
                <PrimaryBtn :disabled="form.processing">Create</PrimaryBtn>
            </div>
        </form>
    </Container>
</template>