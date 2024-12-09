<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import InputField from '../../Components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';

const props = defineProps({
    users: Object,
});

const form = useForm({
    'user_id': '',
    'title': '',
    'body': '',
});

</script>

<template>

    <Head title="- Send Notification" />
    <Container>
        <Title class="mb-6">Send Notification</Title>
        <form @submit.prevent="form.post(route('notification.store'))">
            <div class="mb-6 space-y-4">
                <div class="flex gap-4 items-center">
                    <label for="user" class="block text-sm font-medium text-slate-700 dark:text-slate-300">To </label>
                    <select id="user" v-model="form.user_id"
                        class="text-slate-800 bg-slate-200 border-0 outline-0 rounded-lg text-sm py-1 overflow-y-auto max-h-[50px]">
                        <option disabled selected value="">Please select a user</option>
                        <option value="all">All</option>
                        <option v-for="(user, index) in users.data" :key="index" :value="user.id">
                            {{
                                user.name }}
                        </option>
                    </select>
                </div>
                <InputField label="Title" icon="heading" placeholder="Notification title" v-model="form.title" />
                <InputField label="Message" icon="font" placeholder="Type your message" v-model="form.body" />
            </div>
            <PrimaryBtn>Send Notification</PrimaryBtn>
        </form>
    </Container>
</template>