<template>
    <div id="product-detail-wrapper">
        <div id="product-detail-container">
            <div class="container-lg">
                <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>

                <div class="product-reviews-detail-image">
                    <img :src="p_product.img"/>
                </div>

                <div class="product-detail-container">
                    <div class="product-detail-main">
                        <div class="product-detail-content">
                            <div class="title">{{ p_product.title }}のレビュー一覧</div>


                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="product-reviews">
                        <div class="product-reviews-status">
                            <div class="product-detail-rating-container">
                                <star-rating v-model="p_product.rating" :read-only="true" :show-rating="false"
                                             :star-points="[23,2, 15,18, 0,20, 11,33, 7,50, 23,42, 38,50, 35,33, 46,20, 30,18]"
                                             :star-size="13"></star-rating>
                            </div>
                            （{{ p_product.ratesCount }}）
                        </div>
                        <div class="product-reviews-item" v-for="i_review in i_reviews">

                            <star-rating v-model="i_review.rating" :read-only="true" :show-rating="false"
                                         :star-points="[23,2, 15,18, 0,20, 11,33, 7,50, 23,42, 38,50, 35,33, 46,20, 30,18]"
                                         :star-size="13"></star-rating>
                            <p class="nickname">by {{ i_review.nickname }}<span class="datetime">{{ i_review.datetime }}</span></p>
                            <p class="comment">{{ i_review.comment }}</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</template>

<script>

    import StarRating from 'vue-star-rating';

    export default {
        props: ['breadcrumbs', 'product', 'reviews'],
        components: {
            StarRating
        },
        data() {
            return {

                p_product: JSON.parse(this.product),
                i_reviews: JSON.parse(this.reviews),
            }
        },
        methods: {}
    }
</script>

<style>
    #product-detail-container {
        padding-top: 60px;
        padding-bottom: 40px;
    }

    @media (max-width: 768px) {
        #product-detail-container {
            padding-top: 20px;
        }
    }

    .product-reviews-detail-image {
        float: left;
        width: 160px;
        padding-right: 30px;
    }

    .product-reviews-detail-image img {
        width: 100%;
    }

    .product-detail-container {
        width: calc(100% - 160px);
        display: inline-block;
    }

    .product-detail-content {
        float: left;
    }


    @media (max-width: 600px) {
        .product-reviews-detail-image {
            float: none;
            margin: auto;
            margin-bottom: 20px;
        }

        .product-detail-container {
            width: 100%;
        }

        .product-detail-content {
            float: none;
        }
    }


    .product-detail-content .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 16px;
    }

    .product-detail-content .status {
        margin-top: 20px;
        font-size: 13px;
    }

    .product-detail-content .status span {
        font-weight: bold;
    }

    .product-detail-rating-container {
        float: left;
        margin-top: -2px;
    }

    .product-reviews {
        border: 6px solid #F0F0F0;
    }

    .product-reviews-status {
        background: #F0F0F0;
        padding: 12px;
        font-size: 1rem !important;
        line-height: 2;
    }

    .product-reviews-item {
        padding: 18px;
        border-bottom: 1px solid #F0F0F0;
    }

    .product-reviews-item .title {
        font-size: 16px;
        font-weight: bold;
        line-height: 2rem;
        color: #424242;
        margin-bottom: 0;
    }

    .product-reviews-item .nickname {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .product-reviews-item .nickname span {
        font-weight: normal; padding-left: 10px;
    }

    .product-reviews-item .comment {
        font-size: 14px; margin-bottom: 0;
    }
</style>