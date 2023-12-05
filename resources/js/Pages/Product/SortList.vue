<script setup>
import { Link } from '@inertiajs/vue3'
defineProps(
    {
        products:  Object,
        sort: String,
        categories: Array
    }
)
</script>

<template>
    <div class="sort-action-links">
        <Link :href="'/product-list/name' + (sort === 'name' ? '/desc' : '')">Sort By Name</Link>
        <Link :href="'/product-list/price' + (sort === 'price' ? '/desc' : '')">Sort By Price</Link>
        <Link :href="'/product-list/category' + (sort === 'category' ? '/desc' : '')">Sort By Category</Link>
    </div>
    <li class="product" v-for="product in products.data">
        <Link :href="'/products/' + product.id">Name: {{product.name}}</Link>
        <span class="product-price">Category: {{categories[product.category_id].title}}</span>
        <span class="product-price">Price: {{product.price}}</span>
    </li>
    <div class="pagination">
        <Link :href="products.next_page_url">NextPage</Link>
    </div>
</template>

<style scoped>

</style>
