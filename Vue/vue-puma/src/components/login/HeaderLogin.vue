<template>
    <div id="HeaderLogin" class="p-1 p-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between">
            <div class="d-flex ms-0 ms-md-4">
                <div class="paralelogramo1 w-25 ms-3 mt-2 mt-md-4">
                    <img
                        class="logo-home w-100"
                        src="../../assets/img/logo/logo-sm.png"
                        alt="Logo Puma"
                    />
                </div>
                <Routes></Routes>
            </div>
            <!-- <div class="d-flex align-items-end align-self-end">
                <div class="paralelogramo1">
                    <img
                        class="ico-search p-1 p-md-2 btn"
                        src="../assets/img/icons/search-solid.svg"
                        alt=""
                    />
                </div>
            </div> -->
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

<style scoped>
#headerLogin {
    height: 100vh;
}
</style>
