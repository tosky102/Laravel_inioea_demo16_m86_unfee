<template>
    <a href="javascript:void(0)" class="to-top-icon" @click="scrollToTop"></a>
</template>
<script>
    export default {
        methods: {
            scrollToTop() {
                $('html, body').animate({scrollTop:0},'100');

                // window.scrollTo({
                //     top: 400,
                //     behavior: 'smooth',
                // });
            }
        }
    }
</script>
<style>
    .to-top-icon {
        right: 26px;
        bottom: 26px;
        position: absolute;
        width: 56px; height: 56px;
        background-color: #C0C0C0;
        border-radius: 4px;
        background-image: url("/images/icons/top.svg");
        background-size: 22px;
        background-repeat: no-repeat;
        background-position: center center;
    }

    @media (max-width: 768px) {
        .to-top-icon {
            display: none;
        }
    }

    .to-top-icon:hover {
        opacity: 0.5;
    }
</style>