<template>
    <div id="Home">
        <SwiperBg />
        <swiper
            :direction="'vertical'"
            :slidesPerView="1"
            :loop="true"
            :mousewheel="true"
            class="mySwiper pumaSwiper"
        >
            <swiper-slide><Welcome /></swiper-slide>
            <swiper-slide class="bg-puma-gray"><Resultados /></swiper-slide>
            <swiper-slide class="bg-puma-gray"><Sorteos /></swiper-slide>
            <swiper-slide class="bg-puma-gray"><Ubicanos /></swiper-slide>
            <swiper-slide class="bg-puma-gray"><Testimonios /></swiper-slide>
            <swiper-slide class="bg-puma-gray"><Contactanos /></swiper-slide>
            <SocialMedia />
        </swiper>
    </div>
</template>

<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
// Import Swiper styles
import "swiper/swiper.scss";
import "swiper/components/pagination/pagination.min.css";
// import Swiper core and required modules
import SwiperCore, { Mousewheel, Pagination, Autoplay } from "swiper/core";
// install Swiper modules
SwiperCore.use([Mousewheel, Pagination, Autoplay]);

// @ is an alias to /src
import Welcome from "@/components/home/Welcome.vue";
import Resultados from "@/components/home/Resultados.vue";
import Sorteos from "@/components/home/Sorteos.vue";
import Ubicanos from "@/components/home/Ubicanos.vue";
import Testimonios from "@/components/home/Testimonios.vue";
import Contactanos from "@/components/home/Contactanos.vue";
// ADDS
import SocialMedia from "@/components/SocialMedia.vue";
import SwiperBg from "@/components/SwiperBg.vue";

export default {
    components: {
        Welcome,
        Resultados,
        Sorteos,
        Ubicanos,
        Testimonios,
        Contactanos,
        SocialMedia,
        SwiperBg,

        // Swiper Module
        Swiper,
        SwiperSlide,
    },
    data() {
        return {};
    },
    methods: {},
};
</script>

<style scoped></style>
