<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import { router, useForm } from '@inertiajs/vue3';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import SessionMessages from '../../../Components/SessionMessages.vue';
import UploadAvatar from '../../../Components/UploadAvatar.vue';

const props = defineProps({
    user: Object,
    status: String,
});
const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const resendEmail = (e) => {
    router.post(
        route("verification.send"),
        {},
        {
            onStart: () => (e.target.disabled = true),
            onFinish: () => (e.target.disabled = false),
        }
    );
};

</script>

<template>
    <Container class="mb-6">
        <!-- <div class="col-span-2"> -->
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form @submit.prevent="form.patch(route('profile.info'))" class="space-y-6">
            <InputField label="Name" icon="id-badge" v-model="form.name" class="w-2/3" />
            <InputField label="Email" icon="at" v-model="form.email" class="w-2/3" />
            <div v-if="user.email_verified_at === null">
                <SessionMessages :status="status" />
                <p> Your email is unverified
                    <button @click="resendEmail"
                        class="text-indigo-500 font-medium underline dark:text-indigo-400 disabled:text-slate-300 disabled:cursor-wait">Click
                        here to re-send the verification email</button>
                </p>

            </div>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
        <!-- </div> -->
        <!-- <div class="col-span-1">
            <UploadAvatar />
        </div> -->
    </Container>

</template>