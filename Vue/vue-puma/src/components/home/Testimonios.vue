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
                class="col-12 col-sm-6 col-md-3 d-flex flex-column"
            >
                <img src="" alt="" />
                <h1>Titulo</h1>
            </div>
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
