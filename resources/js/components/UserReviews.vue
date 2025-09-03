<template>
    <div id="user-detail-wrapper">
        <div id="user-detail-container">
            <div class="container-lg">
                <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>

                <div class="user-reviews-detail-image">
                    <img :src="p_user.img"/>
                </div>

                <div class="user-detail-container">
                    <div class="user-detail-main">
                        <div class="user-detail-content">
                            <div class="title">{{ p_user.name }}さんのレビュー一覧</div>


                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="user-reviews">
                        <div class="user-reviews-status">
                            <div class="user-detail-rating-container">
                                <star-rating v-model="p_user.rating" :read-only="true" :show-rating="false"
                                             :star-points="[23,2, 15,18, 0,20, 11,33, 7,50, 23,42, 38,50, 35,33, 46,20, 30,18]"
                                             :star-size="13"></star-rating>
                            </div>
                            （{{ p_user.ratesCount }}）
                        </div>
                        <div class="user-reviews-item" v-for="i_review in i_reviews">
                            <p class="title">{{ i_review.title }}</p>
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
        props: ['breadcrumbs', 'user', 'reviews'],
        components: {
            StarRating
        },
        data() {
            return {

                p_user: JSON.parse(this.user),
                i_reviews: JSON.parse(this.reviews),
            }
        },
        methods: {}
    }
</script>

<style>
    #user-detail-container {
        padding-top: 60px;
        padding-bottom: 40px;
    }

    @media (max-width: 768px) {
        #user-detail-container {
            padding-top: 20px;
        }
    }

    .user-reviews-detail-image {
        float: left;
        width: 160px;
        padding-right: 30px;
    }

    .user-reviews-detail-image img {
        width: 100%;
    }

    .user-detail-container {
        width: calc(100% - 160px);
        display: inline-block;
    }

    .user-detail-content {
        float: left;
    }


    @media (max-width: 600px) {
        .user-reviews-detail-image {
            float: none;
            margin: auto;
            margin-bottom: 20px;
        }

        .user-detail-container {
            width: 100%;
        }

        .user-detail-content {
            float: none;
        }
    }


    .user-detail-content .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 16px;
    }

    .user-detail-content .status {
        margin-top: 20px;
        font-size: 13px;
    }

    .user-detail-content .status span {
        font-weight: bold;
    }

    .user-detail-rating-container {
        float: left;
        margin-top: -2px;
    }

    .user-reviews {
        border: 6px solid #F0F0F0;
    }

    .user-reviews-status {
        background: #F0F0F0;
        padding: 12px;
        font-size: 1rem !important;
        line-height: 2;
    }

    .user-reviews-item {
        padding: 18px;
        border-bottom: 1px solid #F0F0F0;
    }

    .user-reviews-item .title {
        font-size: 16px;
        font-weight: bold;
        line-height: 2rem;
        color: #424242;
        margin-bottom: 0;
    }

    .user-reviews-item .nickname {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .user-reviews-item .nickname span {
        font-weight: normal; padding-left: 10px;
    }

    .user-reviews-item .comment {
        font-size: 14px; margin-bottom: 0;
    }
</style>