<script setup>
import {Link} from '@inertiajs/vue3'
import {useCookies} from 'vue3-cookies'

const {cookies} = useCookies()
const last10VisitedCookies = cookies.isKey('last-10-visited')
    ? cookies.get('last-10-visited')
    : '[]'
let last10Visited = JSON.parse(last10VisitedCookies)

defineProps(
    {
        products: Object,
        sort: String,
        categories: Object,
        topProducts: Object
    }
)
</script>

<template>
    <h1 class="text-3xl font-bold underline mb-2">Catalog:</h1>
    <h2>Top products:</h2>
    <div class="flex mb-4" v-for="topProduct in topProducts">
        <Link class="w-1/2 h-12" :href="'/products/' + topProduct.id">{{ topProduct.name }}</Link>
        <span class="w-1/2 h-12">Price: {{ topProduct.price }}</span>
    </div>

    <div class="flex text-sky-400">
        <Link class="w-1/3 h-12" :href="'/product-list/name' + (sort === 'name' ? '/desc' : '')">Sort By Name</Link>
        <Link class="w-1/3 h-12" :href="'/product-list/category' + (sort === 'category' ? '/desc' : '')">Sort By Category</Link>
        <Link class="w-1/3 h-12" :href="'/product-list/price' + (sort === 'price' ? '/desc' : '')">Sort By Price</Link>
    </div>


    <li class="flex mb-4" v-for="product in products.data">
        <Link class="w-1/3 h-12" :href="'/products/' + product.id">{{ product.name }}</Link>
        <span class="w-1/3 h-12">Category: {{ categories[product.category_id].title }}</span>
        <span class="w-1/3 h-12">Price: {{ product.price }}</span>
    </li>
    <div class="pagination mb-4 text-sky-400">
        <Link :href="products.next_page_url">NextPage</Link>
    </div>
    <div class="last-10-viewed" v-if="last10Visited.length">
        <h2>Last 10 viewed:</h2>
        <div class="flex mb-4" v-for="product in last10Visited">
            <Link class="w-full" :href="'/products/' + product.id">{{ product.name }}</Link>
        </div>
    </div>
</template>

<style scoped>

</style>
