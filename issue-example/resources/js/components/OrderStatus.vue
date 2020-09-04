<template>
    <div>
        <v-icon v-if="orderStatus == 1">home</v-icon>
        <v-icon v-else-if="orderStatus == 2">event</v-icon>
        <v-icon v-else-if="orderStatus == 3">info</v-icon>
        <span v-else>--</span>
    </div>
</template>

<script>
import OrderMixin from "../mixins/OrderMixin.js";

export default {
    name: "OrderStatus",
    props: {
        order: Object
    },
    mixins: [OrderMixin],
    computed: {
        orderStatus() {
            return this.getOrderStatus(this.order);
        }
    }
};
</script>
