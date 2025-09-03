<template>
    <a href="javascript:void(0)" class="sp-to-top-icon" @click="scrollToTop"></a>
</template>
<script>
    export default {
        methods: {
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            }
        }
    }
</script>
<style>
    .sp-to-top-icon {
        right: 12px;
        bottom: 12px;
        position: absolute;
        width: 56px; height: 56px;
        background-color: #C0C0C0;
        border-radius: 4px;
        background-image: url("/images/icons/top.svg");
        background-size: 22px;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .sp-to-top-icon:hover {
        opacity: 0.5;
    }
</style>