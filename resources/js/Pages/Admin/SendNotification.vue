<script setup>
import Container from '../../Components/Container.vue';
import Title from '../../Components/Title.vue';
import ErrorMessages from '../../Components/ErrorMessages.vue';
import SessionMessages from '../../Components/SessionMessages.vue';
import InputField from '../../Components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import { watch } from 'vue';

const props = defineProps({
    users: Object,
    status: String,
});

const form = useForm({
    'user_id': '',
    'title': '',
    'message': '',
});

const sendNotification = () => {
    form.post(route('notification.store'), {
        onFinish: () => {
            form.reset('user_id', 'title', 'message');
        },
    });
};

</script>

<template>

    <Head title="- Send Notification" />
    <Container>
        <Title class="mb-6">Send Notification</Title>
        <ErrorMessages :errors="form.errors" />
        <SessionMessages :status="status" />
        <form @submit.prevent="sendNotification">
            <div class="mb-6 space-y-4">
                <div class="flex gap-4 items-center">
                    <label for="user" class="block text-sm font-medium text-slate-700 dark:text-slate-300">To </label>
                    <select id="user" v-model="form.user_id"
                        class="text-slate-800 bg-slate-200 border-0 outline-0 rounded-lg text-sm py-1 overflow-y-auto max-h-[50px] space-y-1">
                        <option disabled selected value="">Please select a user</option>
                        <option :value="0">All</option>
                        <option v-for="(user, index) in users.data" :key="index" :value="user.id">
                            {{
                                user.name }}
                        </option>
                    </select>
                </div>
                <InputField label="Title" icon="heading" placeholder="Notification title" v-model="form.title" />
                <InputField label="Message" icon="font" placeholder="Type your message" v-model="form.message" />
            </div>
            <PrimaryBtn>Send Notification</PrimaryBtn>
        </form>
    </Container>
</template>