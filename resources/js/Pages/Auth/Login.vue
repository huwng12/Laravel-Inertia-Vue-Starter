<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import CheckBox from "../../Components/CheckBox.vue";
import SessionMessages from "../../Components/SessionMessages.vue";

const form = useForm({
    email: "",
    password: "",
    remember: null,
});

defineProps({
    status: String,
});

const submit = () => {
    // localStorage.setItem('user_logged_in', 'true');
    form.post(route("login"), {
        onFinish: () => {
            form.reset('password');
            window.dispatchEvent(new Event('userLoggedIn'));
        },
    });
};
</script>

<template>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p>Already have an account?
                <TextLink routeName="register" label="Register" />
            </p>
        </div>
        <ErrorMessages :errors="form.errors" />
        <SessionMessages :status="status" />
        <form class="space-y-6" @submit.prevent=submit()>
            <InputField label="Email" icon="at" v-model="form.email" />
            <InputField label="Password" type="password" icon="key" v-model="form.password" />
            <div class="flex items-center justify-between">
                <CheckBox name="remember" v-model="form.remember">Remember me</CheckBox>
                <TextLink routeName="password.request" label="Forgot your password?" />
            </div>
            <PrimaryBtn :disabled="form.processing">Login</PrimaryBtn>
        </form>

    </Container>
</template>