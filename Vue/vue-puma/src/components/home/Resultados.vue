<template>
    <div id="Resultados" class="w-100 py-2 px-1 px-sm-3 px-md-4 px-lg-5">
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
                <div class="d-flex flex-column">
                    <div class="paralelogramo2 d-flex ps-5 py-1">
                        <div class="triangulo-left"></div>
                        <div class="triangulo-right"></div>
                    </div>
                    "Resultados"
                </div>
            </div>
            <div class="paralelogramo menuRoutes"></div>
            <div class="row mt-3">
                <div
                    v-for="(resultado, index) in resultados"
                    :key="index"
                    class="col-4 h-75 d-flex flex-column"
                >
                    <img src="" alt="" />
                    <div class="d-flex align-items-end">
                        <h1 class="paralelogramo1 pe-5">Titulo</h1>
                        <a class="paralelogramo1" href="">ver mas</a>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Veniam illo dolorum animi at quas debitis aut eaque!
                        Labore, repudiandae itaque.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Resultados",
    data() {
        return {
            resultados: 3,
        };
    },
};
</script>
