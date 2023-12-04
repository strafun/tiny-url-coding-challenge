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
    <h2>Create Category:</h2>
    <form @submit.prevent="submit">
        <label for="title">title:</label>
        <input id="title" v-model="form.title" />
        <div v-if="form.errors.title">{{ form.errors.title }}</div>
        <br />
        <button :disabled="form.processing" type="submit">Submit</button>
    </form>
</template>
