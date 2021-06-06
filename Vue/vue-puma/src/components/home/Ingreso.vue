<template>
    <div id="Ingreso" class="d-flex flex-column">
        <!-- LOGIN -->
        <form
            @submit.prevent="login(usuario)"
            class="paralelogramo1 p-2 d-flex flex-column flex-sm-row justify-content-between align-items-center"
        >
            <span class="mx-1"
                >User:
                <input
                    class="w-50"
                    type="email"
                    placeholder="email"
                    required
                    v-model="usuario.email"
            /></span>
            <span class="mx-1"
                >Clave:
                <input
                    class="w-50"
                    type="password"
                    placeholder="pass"
                    required
                    v-model="usuario.password"
            /></span>
            <div class="mx-1">
                <!-- <button type="submit" class="fw-bold">ENTRAR</button> -->
                <router-link to="/login">ENTRAR</router-link>
                <button @click.prevent="" class="m-0">
                    Olvide mi contraseña
                </button>
            </div>
        </form>

        <!-- RECOVER PASS -->
        <form
            @submit.prevent="recoveryPass(forgetPass)"
            class="paralelogramo1 p-2 w-50 align-self-end"
        >
            <input
                class="w-100"
                type="email"
                placeholder="Ingrese correo de recuperación"
                required
                v-model="forgetPass.email"
            />
            <button type="submit" class="fw-bold">
                RECUPERAR
            </button>
        </form>
    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
    name: "Ingreso",
    data() {
        return {
            usuario: {
                email: "",
                password: "",
            },
            forgetPass: {
                email: "",
            },
        };
    },
    methods: {
        ...mapActions(["login", "recoveryPass"]),
    },
    computed: {
        ...mapState(["pass"]),
    },
};
</script>

<style scoped>
#Ingreso * {
    color: var(--text-color2);
}
button {
    border: none;
    background-color: transparent;
}
input {
    border: none;
    border-bottom: 1px solid var(--green);
    background-color: transparent;
}
</style>
