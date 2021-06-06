<template>
    <div id="Contactanos" class="d-flex flex-column h-100 py-3">
        <div>
            <h1>
                Contactanos
            </h1>
        </div>
        <HeaderComponents />
        <form @submit.prevent="contactanos(contacto)" class="row mt-3">
            <div class="col-6">
                <input
                    type="text"
                    required
                    placeholder="Tu nombre"
                    v-model="contacto.name"
                />
                <input
                    type="email"
                    required
                    placeholder="Tu correo"
                    v-model="contacto.email"
                />
            </div>
            <textarea
                class="col-6"
                cols="auto"
                rows="auto"
                required
                placeholder="Tu mensaje"
                v-model="contacto.message"
            ></textarea>
            <button type="submit">Enviar</button>
        </form>
        <div class="paralelogramo1 mt-auto mb-3">
            2021 Chance Puma derechos reservados
        </div>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import HeaderComponents from "./HeaderComponents.vue";

export default {
    name: "Contactanos",
    components: {
        HeaderComponents,
    },
    data() {
        return {
            contacto: {
                email: "",
                name: "",
                message: "",
            },
        };
    },
    methods: {
        ...mapActions(["contactanos"]),
    },
};
</script>
