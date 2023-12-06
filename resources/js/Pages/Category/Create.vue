<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    title: null,
})

function submit() {
    form.post('/categories')
}
</script>

<template>
    <h1 class="text-3xl font-bold underline">Create Category:</h1>
    <form @submit.prevent="submit">
        <div class="space-y-12">
            <label class="block">
                <span class="text-gray-700">Title:</span>
                <input type="text" class="mt-1 block w-full" placeholder="" v-model="form.title" >
                <span class="text-red-500" v-if="form.errors.title">{{ form.errors.title }}</span>
            </label>
            <button  class="btn btn-blue" :disabled="form.processing" type="submit">Create</button>
        </div>
    </form>
</template>

<style>
.btn {
    @apply font-bold py-2 px-4 rounded;
}
.btn-blue {
    @apply bg-blue-500 text-white;
}
.btn-blue:hover {
    @apply bg-blue-700;
}
</style>
