export default {
    methods: {
        getOrderStatus(order) {
            if (!order) return null;
            return order.status;
        }
    }
};
