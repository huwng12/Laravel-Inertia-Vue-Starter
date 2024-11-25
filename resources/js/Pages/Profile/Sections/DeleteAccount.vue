<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import { ref } from 'vue';

const showConfirmPassword = ref(false);
const form = useForm({
    password: "",
});

const deleteAccount = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onFinish: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>Ensure your are using a long, random password to stay secure</p>
        </div>
        <div v-if="showConfirmPassword">
            <ErrorMessages :errors="form.errors" />
            <form @submit.prevent="deleteAccount" class="space-y-6 flex gap-2 items-center">
                <InputField label="Password" icon="key" v-model="form.password" class="w-1/2" />
                <div v-if="form.recentlySuccessful" class="font-bold text-sm text-green-500">Saved!</div>
                <PrimaryBtn :disabled="form.processing">Confirm</PrimaryBtn>
                <button @click="showConfirmPassword = false"
                    class="text-indigo-500 font-medium underline dark:text-indigo-400">Cancel</button>
            </form>
        </div>
        <button v-if="!showConfirmPassword" @click="showConfirmPassword = true"
            class="px-6 py-2 rounded-lg bg-red-500 text-white">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>Delete Account</button>


    </Container>

</template>