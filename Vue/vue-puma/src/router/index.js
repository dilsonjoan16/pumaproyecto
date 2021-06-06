import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "Home",
        component: () =>
            import(/* webpackChunkName: "Home" */ "../views/Home.vue"),
    },
    {
        path: "/login",
        name: "Login",
        component: () =>
            import(/* webpackChunkName: "Login" */ "../views/Login.vue"),
    },
    {
        path: "/login/estado-cuenta",
        name: "EstadoCuenta",
        component: () =>
            import(
                /* webpackChunkName: "EstadoCuenta" */ "../views/login/EstadoCuenta.vue"
            ),
    },
    {
        path: "/login/galerias",
        name: "Galerias",
        component: () =>
            import(
                /* webpackChunkName: "Galerias" */ "../views/login/Galerias.vue"
            ),
    },
    {
        path: "/login/metricas",
        name: "Metricas",
        component: () =>
            import(
                /* webpackChunkName: "Metricas" */ "../views/login/Metricas.vue"
            ),
    },
    {
        path: "/login/promotores-vendedores",
        name: "PromotoresVendedores",
        component: () =>
            import(
                /* webpackChunkName: "PromotoresVendedores" */ "../views/login/PromotoresVendedores.vue"
            ),
    },
    {
        path: "/login/reportar-gastos",
        name: "ReportarGastos",
        component: () =>
            import(
                /* webpackChunkName: "ReportarGastos" */ "../views/login/ReportarGastos.vue"
            ),
    },
    {
        path: "/login/resumen-ventas",
        name: "ResumenVentas",
        component: () =>
            import(
                /* webpackChunkName: "ResumenVentas" */ "../views/login/ResumenVentas.vue"
            ),
    },
    {
        path: "/login/solicitudes",
        name: "Solicitudes",
        component: () =>
            import(
                /* webpackChunkName: "Solicitudes" */ "../views/login/Solicitudes.vue"
            ),
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router;
