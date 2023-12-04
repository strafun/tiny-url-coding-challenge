<script setup>
import { Head } from '@inertiajs/vue3'
import { Link } from "@inertiajs/vue3"

defineProps({ user: Object })
</script>

<template>
        <Head title="Welcome" />
        <h1>Welcome</h1>
        <p>Coding challenge</p>
    <Link href="/product-list">Products sort list</Link>
    <br>
    <Link href="/categories/create">Create category</Link>
    <br>
    <Link href="/products">Products</Link>
    <br>
</template>
