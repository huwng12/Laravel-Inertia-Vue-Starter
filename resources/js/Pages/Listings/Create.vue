<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import InputField from '../../Components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import ImageUpload from '../../Components/ImageUpload.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import SelectCategory from '../../Components/SelectCategory.vue';

const form = useForm({
    'title': '',
    'desc': '',
    'tags': '',
    'email': '',
    'link': '',
    'image': '',
    'category_id': '',
})
const props = defineProps({
    categories: Object,
})
</script>

<template>

    <Head title="- New Listing" />

    <Container>
        <div class="mb-6">
            <Title>Create a new listing</Title>
        </div>
        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="form.post(route('listings.store'))" class="grid grid-cols-2 gap-6">
            <div class="space-y-6">
                <InputField label="Title" icon="heading" placeholder="My new listing" v-model="form.title" />
                <InputField label="Tags" icon="tags" placeholder="My new listing" v-model="form.tags" />
                <TextArea label="TextArea" icon="newspaper" placeholder="This is my listing description"
                    v-model="form.desc" />
                <SelectCategory label="Select Category" :categories="props.categories"
                    @categoryId="e => (form.category_id = e)" />

            </div>

            <div class="space-y-6">
                <InputField label="Email" icon="at" placeholder="example@email.com" v-model="form.email" />
                <InputField label="External Link" icon="up-right-from-square" placeholder="https://example.com"
                    v-model="form.link" />
                <ImageUpload @image="e => (form.image = e)" />
            </div>
            <div>
                <PrimaryBtn :disabled="form.processing">Create</PrimaryBtn>
            </div>
        </form>
    </Container>
</template>