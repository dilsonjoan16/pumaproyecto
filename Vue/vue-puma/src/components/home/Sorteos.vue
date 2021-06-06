<template>
    <div id="Sorteos" class="d-flex flex-column align-items-center h-100 py-3">
        <div>
            <h1>
                Sorteos
            </h1>
        </div>
        <HeaderComponents />
        <!-- <div class="sorteos row m-3 h-auto">
            <div
                v-for="(element, index) in elements"
                :key="index"
                class="col-12 col-sm-6 col-md-3"
            >
                <div>
                    <img src="../../assets/img/img.jpg" alt="" />
                    <p>Titulo</p>
                    <hr />
                </div>
            </div>
        </div> -->
        <div class="sorteos m-3 h-auto d-flex">
            <div v-for="(element, index) in elements" :key="index" class="mx-1">
                <div>
                    <img src="../../assets/img/img.jpg" alt="" />
                    <p>Titulo</p>
                    <hr />
                </div>
            </div>
        </div>
        <div class="mt-auto mb-4 h-50 w-75">
            <img src="../../assets/img/video.jpg" alt="" />
        </div>
    </div>
</template>

<script>
import HeaderComponents from "./HeaderComponents.vue";

export default {
    name: "Sorteos",
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

<style scoped>
.sorteos {
    overflow: auto;
}
</style>
