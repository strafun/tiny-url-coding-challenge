<script setup>
import {Link} from '@inertiajs/vue3'

defineProps(
    {
        products: Object
    }
)
</script>

<template>
    <h2>Admin panel:</h2>
    <Link href="/products/create">Create Product</Link>
    <li v-for="product in products.data">
        <Link :href="'/products/' + product.id">{{ product.name }}</Link>
        <Link :href="'/products/' + product.id +  '/edit'">Edit</Link>
        <Link :href="'/products/' + product.id" method="delete" as="button" type="button">Delete</Link>
    </li>
    <div class="pagination">
        <Link :href="products.first_page_url">First Page</Link>
        <Link v-if="products.prev_page_url"  :href="products.prev_page_url">Previous Page</Link>
        <Link v-if="products.next_page_url" :href="products.next_page_url">Next Page</Link>
    </div>
</template>

<style scoped>

</style>
