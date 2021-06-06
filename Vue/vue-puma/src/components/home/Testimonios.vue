<template>
    <div id="Testimonios" class="d-flex flex-column h-100 py-3">
        <div>
            <h1>
                Testimonios
            </h1>
        </div>
        <HeaderComponents />
        <div class="row mt-3">
            <div
                v-for="(element, index) in elements"
                :key="index"
                class="col-12 col-sm-6 col-md-3"
            >
                {{ index }}
            </div>
        </div>
        <div class="row mt-auto">
            <div class="row col-6">
                <div class="col-12">Tu nombre</div>
                <div class="col-12">Tu correo</div>
            </div>
            <div class="col-6">Tu mensaje</div>
        </div>
        <div class="paralelogramo1 mt-1 mb-3">ENVIAR</div>
        <div class="paralelogramo1 mt-1 mb-3">
            2021 Chance Puma derechos reservados
        </div>
    </div>
</template>

<script>
import HeaderComponents from "./HeaderComponents.vue";

export default {
    name: "Testimonios",
    components: {
        HeaderComponents,
    },
    data() {
        return {
            elements: 4,
        };
    },
};
</script>
