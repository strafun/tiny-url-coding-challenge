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
    <h2>{{ product.id ? "Edit" : 'Create' }} Product</h2>
    <form @submit.prevent="submit">
        <label for="name">name:</label>
        <input id="name" v-model="form.name"/>
        <div v-if="form.errors.name">{{ form.errors.name }}</div>
        <br>
        <label for="description">description:</label>
        <textarea id="description" v-model="form.description" placeholder="Product Description">
        </textarea>
        <br>
        <label for="price">price:</label>
        <input id="price" v-model="form.price"/>
        <div v-if="form.errors.price">{{ form.errors.price }}</div>
        <br>
        <label for="category">category:</label>
        <select id="category" v-model="form.category_id">
            <option disabled value="">Please select one</option>
            <option v-for="category in categories" :value="category.id">{{category.title}}</option>
        </select>
        <br>
        <label for="is-top">Is top product:</label>
        <input id="is-top" type="checkbox" v-model="form.isTop"/>
        <br>
        <button :disabled="form.processing" type="submit">{{ product.id ? "Edit" : 'Create' }}</button>
    </form>

</template>

<style scoped>

</style>
