<template>
    <star-rating v-model="rating" :read-only="true" :show-rating="false"
                 :star-points="[23,2, 15,18, 0,20, 11,33, 7,50, 23,42, 38,50, 35,33, 46,20, 30,18]"
                 :star-size="13"></star-rating>
</template>
<script>

    import StarRating from 'vue-star-rating';

    export default {
        props: ['rating'],
        components: {
            StarRating
        },
        data() {
            // return {
            //     data: JSON.parse()
            // }
        },
    }
</script>