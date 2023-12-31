<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { copyToClipboard, shortenAddress } from "@/utils.js";
import TextareaInput from "@/Components/TextareaInput.vue";

const round = ref(usePage().props.round.valueOf());
const prompt = ref(usePage().props.prompt.valueOf());
// const system_prompt = ref(""); // New reactive property for system prompt
// const evaluationPrompt = ref(""); // New reactive property for evaluation prompt

const form = useForm({
    system_prompt: "",
    prompt: "",
});

if (prompt.value) {
    form.system_prompt = prompt.value.system_prompt;
    form.prompt = prompt.value.prompt;
}

const savePrompts = async () => {
    form.post(
        route("round.prompt.upsert", {
            round: round.value.id,
        }),
        {
            onSuccess: (response) => {
                // form.system_prompt.value = response.props.system_prompt;
                // form.prompt.value = response.props.prompt;
            },
            onError: (error) => {},
        }
    );
};

const addAccessControl = () => {
    form.post(route("access-control.upsert", {}), {
        onSuccess: (response) => {
            accessControls.value = response.props.accessControls;
        },
        onError: (error) => {},
    });

    form.eth_addr = "";
    form.role = "admin";
};
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ round.name }}
                <span class="text-sm">
                    {{ shortenAddress(round.round_addr) }}

                    <span
                        @click="copyToClipboard(round.round_addr)"
                        class="cursor-pointer"
                    >
                        <i class="fa fa-clone" aria-hidden="true"></i>
                    </span>
                </span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <h2>Evaluation Criteria</h2>

                <div class="mb-4">
                    <label
                        for="system-prompt"
                        class="block text-gray-700 text-sm font-bold mb-2"
                        >System Prompt:</label
                    >
                    <TextareaInput
                        id="system-prompt"
                        v-model="form.system_prompt"
                        rows="4"
                    />
                </div>

                <div class="mb-4">
                    <label
                        for="evaluation-prompt"
                        class="block text-gray-700 text-sm font-bold mb-2"
                        >Evaluation Prompt:</label
                    >
                    <TextareaInput
                        id="evaluation-prompt"
                        v-model="form.prompt"
                        rows="4"
                    />
                </div>

                <div class="mt-4 text-right">
                    <Link
                        :href="route('round.show', { round: round.id })"
                        class="mr-3"
                        >Round Projects</Link
                    >
                    <PrimaryButton @click="savePrompts">Save</PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
