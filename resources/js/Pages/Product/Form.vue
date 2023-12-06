<script setup>
import {useForm} from '@inertiajs/vue3'

const props = defineProps(
    {
        product: Object,
        categories: Object,
    }
)
const form = useForm({
    name: props.product?.name,
    description: props.product?.description,
    price: props.product?.price,
    category_id: props.product?.category_id,
    isTop: props.product?.isTop,
})
function submit() {
    props.product?.id ? form.put('/products/' + props.product?.id) : form.post('/products')
}
</script>

<template>
    <h1 class="text-3xl font-bold underline">{{ product.id ? "Edit" : 'Create' }} Product</h1>
    <form @submit.prevent="submit">
        <div class="space-y-12">
            <label class="block">
                <span class="text-gray-700">Name:</span>
                <input type="text" class="mt-1 block w-full" placeholder="" v-model="form.name" >
                <span class="text-red-500" v-if="form.errors.name">{{ form.errors.name }}</span>
            </label>
            <label for="description">
                <span class="text-gray-700">Description:</span>
                <textarea class="mt-1 block w-full" id="description" v-model="form.description" placeholder="Product Description">
                </textarea>
                <span class="text-red-500" v-if="form.errors.description">{{ form.errors.description }}</span>
            </label>
            <label class="block">
                <span class="text-gray-700">Price:</span>
                <input type="text" class="mt-1 block w-full" placeholder="" v-model="form.price" >
                <span class="text-red-500" v-if="form.errors.price">{{ form.errors.price }}</span>
            </label>
            <div >
                <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Category:</label>
                <select id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    <option disabled value="">Please select one</option>
                    <option v-for="category in categories" :value="category.id">{{category.title}}</option>
                </select>
                <span class="text-red-500" v-if="form.errors.category_id">{{ form.errors.category_id }}</span>
            </div>
            <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                    <input v-model="form.isTop" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                </div>
                <div class="text-sm leading-6">
                    <label for="comments" class="font-medium text-gray-900">Top product:</label>
                </div>
            </div>
            <button  class="btn btn-blue" :disabled="form.processing" type="submit">{{ product.id ? "Edit" : 'Create' }}</button>
        </div>
    </form>

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
