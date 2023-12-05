<script>
import {useCookies} from 'vue3-cookies';

export default {
    setup() {
        const {cookies} = useCookies();
        return {cookies};
    },
    props: {
        product: Object,
    },
    mounted() {
        const last10VisitedCookies = this.cookies.isKey("last-10-visited")
            ? this.cookies.get("last-10-visited")
            : '[]';
        let last10Visited = JSON.parse(last10VisitedCookies);

        last10Visited = last10Visited.filter(object => {
            return object.id !== this.product.id;
        });
        last10Visited.push({
            id: this.product.id,
            name: this.product.name
        });
        if (last10Visited.length > 10) {
            last10Visited.shift();
        }
        this.cookies.set("last-10-visited", JSON.stringify(last10Visited));
    }
}
</script>


<template>
    <h3>{{ product.name }}</h3>
    <p>{{ product.productDetails?.description }}</p>
    <span>{{ product.price }}</span>
</template>

<style scoped>

</style>
