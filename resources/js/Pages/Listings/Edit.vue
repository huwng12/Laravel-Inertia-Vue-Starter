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
import CKEditor from '../../Components/CKEditor.vue';
import { watch } from 'vue';

const props = defineProps({
    listing: Object,
    categories: Array
})

const form = useForm({
    'title': props.listing.title,
    'desc': props.listing.desc,
    'tags': props.listing.tags,
    'email': props.listing.email,
    'link': props.listing.link,
    'image': '',
    'category_id': props.listing.category_id,
    _method: 'PUT'
})
console.log('form:', form.desc);

watch(() => form.desc, (newValue) => {
    console.log('Updated desc:', newValue);
});
</script>

<template>

    <Head title="- Edit Listing" />

    <Container>
        <div class="mb-6">
            <Title>Edit listing</Title>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form @submit.prevent="form.post(route('listings.update', listing.id))">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="space-y-6">
                    <InputField label="Title" icon="heading" placeholder="My new listing" v-model="form.title" />
                    <InputField label="Tags" icon="tags" placeholder="My new listing" v-model="form.tags" />
                    <!-- <TextArea label="TextArea" icon="newspaper" placeholder="This is my listing description"
                        v-model="form.desc" /> -->
                    <ImageUpload @image="e => (form.image = e)" :listingImage="listing.image" />
                </div>

                <div class="space-y-6">
                    <InputField label="Email" icon="at" placeholder="example@email.com" v-model="form.email" />
                    <InputField label="External Link" icon="up-right-from-square" placeholder="https://example.com"
                        v-model="form.link" />
                    <SelectCategory label="Select Category" :categories="props.categories"
                        :categoryId="form.category_id" @categoryId="e => (form.category_id = e)" />
                </div>
            </div>
            <div>
                <label :for="label" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Description
                </label>
                <CKEditor v-model="form.desc" />
            </div>
            <div class="mt-4">
                <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
            </div>
        </form>
    </Container>
</template>