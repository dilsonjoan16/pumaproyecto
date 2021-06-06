<template>
    <div id="HeaderLogin" class="w-100 py-2 px-1 px-sm-3 px-md-4 px-lg-5">
        <div class="d-flex flex-column">
            <!-- LOGO & NAV -->
            <div class="d-flex ms-0 ms-md-4">
                <!-- LOGO -->
                <div class="paralelogramo1 ms-3 mt-2 mt-md-4">
                    <img
                        class="logo-home"
                        src="../../assets/img/logo/logo-sm.png"
                        alt="Logo Puma"
                    />
                </div>
                <!-- NAV -->
                <Routes></Routes>
            </div>
            <!-- SEARCH BTN -->
            <div class="d-flex align-self-end mt-3">
                <div class="paralelogramo1">
                    <img
                        class="ico-search p-1 p-md-2"
                        src="../../assets/img/icons/search-solid.svg"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Routes from "./Routes.vue";
export default {
    name: "HeaderLogin",
    components: {
        Routes,
    },
};
</script>

<style scoped></style>
