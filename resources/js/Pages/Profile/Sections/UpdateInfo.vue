<script setup>
import Container from '../../../Components/Container.vue';
import Title from '../../../Components/Title.vue';
import InputField from '../../../Components/InputField.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';

const props = defineProps({
    user: Object,
});
const form = useForm({
    name: props.name,
    email: props.email,
});
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>

        <form @submit.prevent="form.patch()">
            <InputField label="Name" icon="id-badge" v-model="form.name" class="w-1/2"></InputField>
            <InputField label="Email" icon="at" v-model="form.email" class="w-1/2"></InputField>
            <div>
                <p>Your email address is unverified.</p>
            </div>
            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>

</template>