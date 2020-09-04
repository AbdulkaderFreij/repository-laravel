import Vue from "vue";
import VueRouter from "vue-router";
import Issue from "../js/components/Issue.vue";
import Test from "../js/components/Test.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "test",
        component: Test,
      },
  {
    path: "/issue",
    name: "issue",
    component: Issue,
  },
];

const router = new VueRouter({
  routes,
});

export default router;
