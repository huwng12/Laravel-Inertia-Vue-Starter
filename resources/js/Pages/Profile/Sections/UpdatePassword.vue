<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '../../../Components/ErrorMessages.vue';

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onFinish: () => {
            form.reset();
        },
    });
}
console.log(form)
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>Ensure your are using a long, random password to stay secure</p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form @submit.prevent="updatePassword" class="space-y-6">
            <InputField label="Current Password" icon="key" v-model="form.current_password" class="w-1/2" />
            <InputField label="Password" icon="key" v-model="form.password" class="w-1/2" />
            <InputField label="Confirmation Password" icon="key" v-model="form.password_confirmation" class="w-1/2" />
            <div v-if="form.recentlySuccessful" class="font-bold text-sm text-green-500">Saved!</div>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>

    </Container>

</template>