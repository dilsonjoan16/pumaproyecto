<template>
    <div id="SwiperBg">
        <swiper
            :loop="true"
            :centeredSlides="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            class="mySwiper position-absolute"
        >
            <swiper-slide
                ><img src="../assets/img/background/bg-general.png" alt=""
            /></swiper-slide>
            <swiper-slide
                ><img src="../assets/img/background/bg-home.png" alt=""
            /></swiper-slide>
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

export default {
    name: "SwiperBG",
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {};
    },
    methods: {},
};
</script>
