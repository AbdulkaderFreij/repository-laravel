<template>
    <div class="text-center">
        <v-menu down :offset-y="offset">
            <template v-slot:activator="{ on, attrs, value }">
                <v-btn color="#3dd475" dark small v-bind="attrs" v-on="on">
                    {{ result }}
                    <v-icon v-if="value">mdi-chevron-down</v-icon>
                    <v-icon v-else>mdi-chevron-up</v-icon>
                </v-btn>
            </template>

            <v-list>
                <v-list-item
                    v-for="(item, index) in items"
                    :key="index"
                    @click="changeStatus(item.value)"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: ["id", "status"],
    data: () => ({
        items: [
            { title: "UNDER_PROCESS", value: 1 },
            { title: "RESOLVED", value: 2 }
        ],
        offset: true,
        statusValue: null
    }),
    computed: {
        result() {
            switch (this.statusValue) {
                case 0:
                    return "Placed";
                case 1:
                    return "Under Process";
                case 2:
                    return "Resolved";
            }
            return "N/A";
        }
    },
    mounted() {
        this.statusValue = this.status;
    },
    methods: {
        changeStatus(value) {
            this.statusValue = value;
            axios
                .put(`http://127.0.0.1:8000/api/issues/${this.id}`, {
                    status: this.statusValue
                })
                .then(response => {
                    console.log(response);
                });
            this.$emit("save");
        }
    }
};
</script>
