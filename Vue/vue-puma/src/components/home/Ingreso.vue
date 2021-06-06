<template>
    <div id="Ingreso" class="d-flex flex-column">
        <form
            id="loginForm"
            action=""
            class="paralelogramo1 p-2 d-flex flex-column flex-sm-row justify-content-between align-items-center"
        >
            <span class="mx-1">User: <input class="w-50" type="text"/></span>
            <span class="mx-1"
                >Clave: <input class="w-50" type="password"
            /></span>
            <div class="mx-1">
                <button id="login" class="fw-bold" @click.prevent="">
                    <!-- ENTRAR -->
                    <router-link to="/login">ENTRAR</router-link>
                </button>
                <button @click.prevent="" class="m-0">
                    Olvide mi contraseña
                </button>
            </div>
        </form>
        <div class="paralelogramo1 p-2 w-50 align-self-end">
            <input
                class="w-100"
                type="text"
                placeholder="Ingrese correo de recuperación"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "Ingreso",
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
