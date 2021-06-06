<template>
    <div id="SocialMedia">
        <div class="pumaFollows">
            asd
            <div>
                <a href="https://www.instagram.com/" target="_blanck">
                    <img
                        src="../assets/img/icons/instagram-brands.svg"
                        alt="Ir a Instagram"
                    />
                </a>
                <a href="https://www.facebook.com/" target="_blanck">
                    <img
                        src="../assets/img/icons/facebook-square-brands.svg"
                        alt="Ir a Facebook"
                    />
                </a>
                <a href="https://wa.me/584247469327" target="_blanck">
                    <img
                        src="../assets/img/icons/whatsapp-brands.svg"
                        alt="Ir a Whatsapp"
                    />
                </a>
            </div>
            <div>
                <div class="btn">
                    push
                    <img src="../assets/img/icons/heart-solid.svg" alt="" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SocialMedia",
};
</script>

<style scoped>
.pumaFollows {
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: 1;
}
</style>
