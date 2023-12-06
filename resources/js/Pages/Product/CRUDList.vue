<script setup>
import {Link} from '@inertiajs/vue3'

defineProps(
    {
        products: Object
    }
)
</script>

<template>
    <h1 class="text-3xl font-bold underline mb-2">Admin panel:</h1>
    <Link class="btn btn-blue mb-4"  type="button" href="/products/create">Create Product</Link>
    <div class="flex mb-4" v-for="product in products.data">
        <Link class="w-1/3 h-12" :href="'/products/' + product.id">{{ product.name }}</Link>
        <Link class="w-1/3 h-12" :href="'/products/' + product.id +  '/edit'">Edit</Link>
        <Link class="w-1/3 h-12" :href="'/products/' + product.id" method="delete" as="button" type="button">Delete</Link>
    </div>

    <div class="flex">
        <Link class="w-1/3 h-12" :href="products.first_page_url">First Page</Link>
        <Link class="w-1/3 h-12" v-if="products.prev_page_url"  :href="products.prev_page_url">Previous Page</Link>
        <Link class="w-1/3 h-12" v-if="products.next_page_url" :href="products.next_page_url">Next Page</Link>
    </div>
</template>

<style scoped>
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
