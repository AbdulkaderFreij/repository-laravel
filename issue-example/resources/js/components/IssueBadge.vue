<template>
    <v-badge bordered color="#ff5452" :content="issueBadge" :value="issueBadge">
        <v-icon v-if="issueBadge!=null" medium class="mr-2">
            mdi-cart
        </v-icon>
        <span v-else medium class="mr-2">
            --
        </span>
    </v-badge>
</template>

<script>
import IssueBadge from "./IssueBadge";
export default {
    name: "IssueBadge",
    props: {
        order: Object
    },
        computed: {
        issueBadge() {
            return this.getIssueBadge(this.order);
        }
    },
    methods:{
        getIssueBadge(order){
            if (!order) return null;
            return order.products_quantity;
        }
    }
};
</script>
