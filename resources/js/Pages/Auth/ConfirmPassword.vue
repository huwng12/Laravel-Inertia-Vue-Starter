<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import ErrorMessages from "../../Components/ErrorMessages.vue";
import InputField from "../../Components/InputField.vue";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Confirm your password</Title>
        </div>
        <ErrorMessages :errors="form.errors" />
        <form class="space-y-6" @submit.prevent=submit()>
            <InputField label="Password" type="password" icon="key" v-model="form.password" />
            <PrimaryBtn :disabled="form.processing">Confirm</PrimaryBtn>
        </form>

    </Container>
</template>