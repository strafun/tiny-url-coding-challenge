<script setup>
    import {Link} from '@inertiajs/vue3'
</script>

<template>
    <main>
        <header class="bg-white">
            <nav class="max-w-xl mx-auto py-12 divide-y md:max-w-4xl" aria-label="Global">
                <div class="hidden lg:flex lg:gap-x-12">
                    <Link class="text-sm font-semibold leading-6 text-gray-900" href="/">Homepage</Link>
                    <Link class="text-sm font-semibold leading-6 text-gray-900" href="/product-list/name">Products sort list</Link>
                    <Link class="text-sm font-semibold leading-6 text-gray-900" href="/categories/create">Create category</Link>
                    <Link class="text-sm font-semibold leading-6 text-gray-900" href="/products">Products</Link>
                </div>
            </nav>
        </header>
        <div class="max-w-xl mx-auto py-12 divide-y md:max-w-4xl">
            <slot />
        </div>
    </main>
</template>
