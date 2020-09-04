<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            :color="color"
            :expand-on-hover="expandOnHover"
            :mini-variant="miniVariant"
            :right="right"
            :permanent="permanent"
            :src="bg"
            absolute
            dark
            app
        >
            <v-list dense nav class="py-0">
                <v-list-item two-line :class="miniVariant && 'px-0'">
                    <v-list-item-avatar>
                        <img
                            src="https://randomuser.me/api/portraits/men/81.jpg"
                        />
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>Tarek</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>

                <v-list-item v-for="item in items" :key="item.title" link>
                    <v-list-item-icon>
                        <v-icon @click="navigateTo({ name: item.name })">{{
                            item.icon
                        }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title
                            @click="navigateTo({ name: item.name })"
                            >{{ item.title }}</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar color="#33475f" dense dark app>
            <v-btn v-on:click="toggleSideBar" icon>
                <v-icon color="green">mdi-chevron-left-box</v-icon>
            </v-btn>
            <v-toolbar-title>
                <span v-if="$route.name == 'test'">Home</span>
            </v-toolbar-title>
            <v-toolbar-title>
                <span v-if="$route.name == 'issue'">Issues</span>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-col cols="6" sm="3" md="2">
                <v-text-field
                    color="#33475f"
                    background-color="white"
                    dense
                    flat
                    hide-details
                    label="Search"
                    single-line
                    outlined
                    solo-inverted
                >
                    <v-icon slot="prepend-inner" color="black">
                        mdi-magnify
                    </v-icon>
                </v-text-field>
            </v-col>

            <v-col cols="6" sm="3" md="2">
                <v-text-field
                    color="#33475f"
                    background-color="white"
                    dense
                    flat
                    hide-details
                    placeholder="Search"
                    single-line
                    outlined
                    solo-inverted
                >
                    <v-icon slot="prepend-inner" color="black">
                        mdi-magnify
                    </v-icon>
                </v-text-field>
            </v-col>
        </v-app-bar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            navigateTo(route) {
                this.$router.push(route);
            },
            drawer: true,
            items: [
                { title: "Home", icon: "mdi-home", name: "test" },
                {
                    title: "Issues",
                    icon: "mdi-help-circle-outline",
                    name: "issue"
                }
            ],
            color: "rgb(250, 250, 255)",
            colors: ["primary", "blue", "success", "red", "teal"],
            right: false,
            permanent: true,
            miniVariant: true,
            expandOnHover: false,
            background: false
        };
    },
    computed: {
        bg() {
            return this.background
                ? "https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg"
                : undefined;
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        toggleSideBar() {
            if (this.miniVariant) {
                this.miniVariant = false;
            } else if (!this.miniVariant) {
                this.miniVariant = true;
            }
        }
    }
};
</script>

<style scoped>
div.col-sm-3:nth-child(4)
    > div:nth-child(1)
    > div:nth-child(1)
    > div:nth-child(1)
    > div:nth-child(3)
    > label:nth-child(1) {
    color: "black" !important;
}
.v-text-field.v-text-field--solo .v-label {
    color: "black" !important;
}

div.v-list-item:nth-child(1) > div:nth-child(2),
.mdi-help-circle-outline,
div.v-list-item:nth-child(3) > div:nth-child(2),
div.v-list-item:nth-child(4) > div:nth-child(2) > div:nth-child(1),
.mdi-home {
    color: black;
}
</style>
