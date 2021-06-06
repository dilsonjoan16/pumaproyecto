<template>
    <div id="Login">
        <h1>{{ dataUser }}</h1>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    name: "Login",
    data() {
        return {};
    },
    computed: {
        ...mapState(["dataUser"]),
    },
};
</script>
