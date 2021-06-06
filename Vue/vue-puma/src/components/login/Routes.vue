<template>
    <div id="Routes" class="d-flex flex-column mx-2 fs-6">
        <div class=" d-flex flex-wrap justify-content-center">
            <router-link
                class="paralelogramo d-flex align-items-center h-auto mt-1 px-2 py-1"
                to="/login"
                >Mi perfil</router-link
            >
            <router-link
                v-for="(ruta, index) in rutas"
                :key="index"
                class="paralelogramo d-flex align-items-center mt-1 px-2 py-1"
                :to="`/login/${ruta}`"
                >{{ ruta }}</router-link
            >
            <router-link
                class="paralelogramo d-flex align-items-center h-auto mt-1 px-2 py-1"
                to="/"
                >Salir</router-link
            >
            <a
                to="/"
                class="paralelogramo d-flex align-items-center h-auto mt-1 px-2 py-1"
                @click="logout"
                >Salir token</a
            >
        </div>
        <div class="paralelogramo menuRoutes"></div>
        {{ dataUsers }}
    </div>
</template>
<script>
import { mapActions, mapState } from "vuex";
export default {
    name: "Routes",
    data() {
        return {
            rutas: [
                "estado-cuenta",
                "galerias",
                "metricas",
                "promotores-vendedores",
                "reportar-gastos",
                "resumen-ventas",
                "solicitudes",
            ],
        };
    },
    methods: {
        ...mapActions(["logout"]),
    },
    computed: {
        ...mapState(["dataUsers"]),
    },
};
</script>
<style scoped>
#Routes a {
    font-weight: 500;
    text-decoration: none;
    color: var(--text-white);
}
#Routes a:hover,
#Routes a.router-link-exact-active {
    color: var(--text-color2);
}
</style>
