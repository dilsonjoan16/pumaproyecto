<template>
    <div id="nav" v-if="$route.name !== 'Home'">
        <HeaderLogin />
    </div>
    <router-view class="bg-puma-gray" />
</template>

<script>
import { mapActions } from "vuex";

import HeaderLogin from "@/components/login/HeaderLogin.vue";
export default {
    // name: "nav",
    components: {
        HeaderLogin,
    },
    methods: {
        ...mapActions(["readToken", "getDataHome"]),
    },
    created() {
        this.readToken();
        this.getDataHome();
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
</style>
