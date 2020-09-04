<template>
    <v-app>
      <example-component />
      <v-main>
        <v-container fluid>
          <router-view></router-view>
        </v-container>
      </v-main>
    </v-app>
</template>

<script>
import ExampleComponent from "../components/ExampleComponent.vue";
export default {
  name: "app",
  components: {
    ExampleComponent,
  },
};
</script>
