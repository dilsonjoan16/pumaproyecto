<template>
    <div id="nav" v-if="$route.name !== 'Home'">
        <Header />
    </div>
    <router-view />
</template>

<script>
import Header from "@/components/login/Header.vue";
export default {
    name: "nav",
    components: {
        Header,
    },
};
</script>

<style lang="scss">
// @import url("https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css");
@import url("./assets/lib/bootstrap-5/css/bootstrap.min.css");
@import url("./assets/css/index.css");
#app {
    text-align: center;
    color: var(--text-black);
}
.bg-puma-gray {
    background-color: var(--white);
    background-image: url("./assets/img/background/bg-sm.svg");
    background-repeat: no-repeat;
    background-position: 100% 50%;
    background-size: 50% 75%;
}
/* #nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
} */
</style>
