<script setup>
import Container from "../../Components/Container.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import SessionMessages from "../../Components/SessionMessages.vue";

const form = useForm({
    email: "",
});

defineProps({
    status: String,
})

const submit = () => {
    form.post(route("password.email"), {
        onError: () => form.reset('email'),
    });
};
</script>

<template>

    <Head title="- Forgot Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>
                Forgot your password? No problem. Just let us know your email address and we will email you a
                password
                reset link that will allow you to choose a new one.
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <SessionMessages :status="status" />
        <form class="space-y-6" @submit.prevent=submit()>
            <InputField label="Email" icon="at" v-model="form.email" />

            <PrimaryBtn :disabled="form.processing">Login</PrimaryBtn>
        </form>

    </Container>
</template>