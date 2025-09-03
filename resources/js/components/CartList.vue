<template>
    <div id="cart-wrapper">
        <div id="cart-container">
            <div class="container-lg">
                <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>
                <h2 class="cart-page-title">
                    <div class="title">{{ title }}</div>
                    <div class="status" v-bind:class="step_class">
                        <ul>
                            <li>決済画面</li>
                            <li>決済確認</li>
                            <li>決済完了</li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </h2>

                <div class="row">
                    <div class="cart-list-items">
                        <div class="cart-list-items-container">
                            <div class="cart-list-items-header">
                                <h3 class="title">求人一覧</h3>
                                <h3 class="point">
                                    価格
                                </h3>
                            </div>
                            <div class="cart-list-items-body">
                                <div class="cart-list-item" v-for="item in c_items">
                                    <div class="cart-list-item-image-container">
                                        <img :src="item.img" />
                                    </div>
                                    <div class="cart-list-item-container">
                                        <div class="cart-list-item-content">
                                            <h3 class="title">{{ item.title }}</h3>
                                            <p class="user">
                                                <img :src="item.seller_img" />
                                                <a :href="item.user_url">{{ item.seller_name }}</a>
                                            </p>

                                            <div class="delete" v-if="mode=='index'">
                                                <a :href="item.cart_delete_url">削除する</a>
                                            </div>
                                        </div>

                                        <div class="cart-list-item-point">
                                            {{ item.price }}<span>pt</span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="text-center" v-if="c_items.length == 0">
                                    カートになにもありません
                                </div>
                            </div>

                            <div class="cart-list-items-footer">

                                <div class="total">
                                    小計（{{ c_vars.count }}点）<span class="price">{{ c_vars.total }}</span> pt
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-list-buttons">
                        <div class="cart-list-buttons-container">
                            <div class="main">
                                <button class="cart-main-button" v-if="mode=='index'" @click="goConfirm()">決済画面に進む</button>

                                <form action="/cart/complete" method="post" id="cartCompleteForm">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="user_id" :value="c_vars.user_id">
                                    <button type="button" class="cart-main-button" v-if="mode=='confirm'" @click="goComplete()">ポイント決済する</button>

                                </form>


                                <div class="total" v-if="display_point">
                                    現在のポイント<span class="price">{{ c_vars.point }}</span> pt
                                </div>

                                <div class="total">
                                    小計（{{ c_vars.count }}点）<span class="price">{{ c_vars.total }}</span> pt
                                </div>
                            </div>

                            <div class="sub">
                                <a :href="c_vars.buy_point_url" target="_blank" class="cart-sub-button" v-if="mode=='confirm'">ポイント購入する</a>

                                <button class="cart-sub-button" @click="goItems()" v-if="mode != 'confirm'">買い物を続ける</button>
                                <button class="cart-sub-button" @click="goBack()" v-if="mode == 'confirm'">決済画面に戻る</button>

                                <a :href="c_vars.purchased_item_url" target="_blank" class="cart-sub-button" v-if="mode=='complete'">購入履歴を見る</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="cart-relation-container" v-if="r_products.length > 0">
            <div class="container-relation" ref="list_page_wrapper" >
                <div class="container-inner-relation" :style="{ width: suggestWidth + 'px' }">
                    <div class="cart-section-item">
                        <h2>
                            よく一緒に購入されている求人
                            <span class="cart-section-item-link"><a :href="c_vars.productUrl1">もっと見る</a></span>
                        </h2>
                        <div class="product-items-container">
                            <product-item v-for="(r_product, index) in r_products" :item="r_product" :key="index"></product-item>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-relation-container even">
            <div class="container-relation">
                <div class="container-inner-relation" :style="{ width: suggestWidth + 'px' }">
                    <div class="cart-section-item">
                        <h2>
                            ランキング人気求人
                            <span class="cart-section-item-link"><a :href="c_vars.productUrl2">もっと見る</a></span>
                        </h2>
                        <div class="product-items-container">
                            <product-item v-for="(s_product, index) in s_products" :item="s_product" :key="index"></product-item>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-relation-container">
            <div class="container-relation">
                <div class="container-inner-relation" :style="{ width: suggestWidth + 'px' }">
                    <div class="cart-section-item">
                        <h2>
                            最近閲覧した求人
                            <span class="cart-section-item-link"><a :href="c_vars.productUrl3">もっと見る</a></span>
                        </h2>
                        <div class="product-items-container">
                            <product-item v-for="(l_product, index) in l_products" :item="l_product" :key="index"></product-item>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>



        <to-top></to-top>
    </div>
</template>

<script>

    export default {
        // props: ['breadcrumbs', 'product', 'relationproducts', 'sellerproducts', 'lastbrowseproducts'],
        props: ['title', 'breadcrumbs', 'mode', 'relationproducts', 'sellerproducts', 'lastbrowseproducts', 'items', 'cartvars'],

        data() {
            return {
                suggestWidth: null,
                detailMainImageHeight: null,
                detailSubImageWidth: null,
                detailSubImageHeight: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                r_products: JSON.parse(this.relationproducts),
                s_products: JSON.parse(this.sellerproducts),
                l_products: JSON.parse(this.lastbrowseproducts),
                c_items: JSON.parse(this.items),
                c_vars: JSON.parse(this.cartvars),
                step_class : 'step-1',
                display_point: false,
                itemsDisplay: 0,
            }
        },
        mounted() {
            this.handleResize();
            if (this.mode == 'index') {
                this.step_class = 'step-1';
                this.display_point = false;
            } else if (this.mode == 'confirm') {
                this.step_class = 'step-2';
                this.display_point = true;
            } else if (this.mode == 'complete') {
                this.step_class = 'step-3';
                this.display_point = true;
            }
        },
        methods: {
            handleResize() {

                let window_width = window.innerWidth;

                if (this.$refs.list_page_wrapper) {
                    if (window_width >= 768) {
                        let wrapper_width = this.$refs.list_page_wrapper.clientWidth;

                        let iWidth = 210;
                        let suggestWidth = iWidth;
                        for (var i = 1; i < 100; i++) {
                            iWidth = 195 * i + 210;
                            if (iWidth > wrapper_width) break;
                            suggestWidth = iWidth;
                        }
                        this.suggestWidth = suggestWidth;
                        this.itemsDisplay = i;

                    } else {
                        let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
                        this.suggestWidth = wrapper_width;
                        this.itemsDisplay = 2;
                    }
                }

            },
            goConfirm() {
                location.href=this.c_vars.confirm_url;
            },
            goBuyPoint() {
                location.href=this.c_vars.buy_point_url;
            },
            goItems() {
                location.href=this.c_vars.items_url;
            },
            goBack() {
                location.href=this.c_vars.index_url;
            },
            goComplete() {
                if (this.c_vars.possible) {
                    $('#cartCompleteForm').submit();
                } else {
                    alert('ポイントが足りません。ポイントを購入してください。')
                }
            }

        },
        created() {
            window.addEventListener('resize', this.handleResize);
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize);
        },
    }
</script>

<style>
    #cart-container {
        padding-top: 60px;
        padding-bottom: 40px;
    }

    @media (max-width: 768px) {
        #cart-container {
            padding-top: 20px;
        }
    }

    .cart-page-title {
        font-size: 27px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .cart-page-title {
            margin-bottom: 10px;
        }
    }

    .cart-main-image {
        width: 100%;
        background-color: #E6E6E6;
        position: relative;
        margin-bottom: 16px;
    }

    .cart-main-image img {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        height: 100%;
    }

    .cart-sub-images-container {
        margin-right: -8px;
        margin-bottom: 16px;
    }

    .cart-sub-image {
        float: left;
        margin-right: 8px;
        position: relative;
        background-color: #E6E6E6;
        margin-bottom: 8px;
    }

    .cart-sub-image img {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        height: 100%;
    }

    .cart-sub-image img:hover {
        cursor: pointer;
    }

    .cart-content {
        margin-top: 6px;
        margin-bottom: 100px;
    }

    @media (max-width: 768px) {
        .cart-content {
            margin-bottom: 20px;
        }
    }

    .cart-content-sub-container {
        margin-bottom: 20px;
    }
    .cart-content-span {
        font-size: 12px;
        padding: 4px 12px;
        background-color: #F5F5F5;
        border: 1px solid #B3B3B3;
        border-radius: 16px;
        color: #333333;
    }

    .cart-content-text {
        font-size: 15px;
        margin-top: 10px;
        color: #666666;
    }

    .cart-content-link {
        font-size: 15px;
        color: #666666;
        text-decoration: underline;
    }

    .cart-content-link:hover {
        text-decoration: none;
        color: #666666;
    }

    .cart-content-link:visited {
        color: #666666;
    }

    .cart-content-category {
        margin-top: 10px;
    }

    .cart-content-category .cart-content-link+.cart-content-link {
        margin-left: 16px;
    }

    .cart-content-review .cart-content-link{
        font-size: 13px;
    }

    .cart-rating-container {
        float: left;
        margin-top: -2px;
    }

    .cart-price {
        margin-bottom: 16px;
    }

    .cart-price p {
        font-size: 30px;
    }

    .cart-price span {
        font-size: 17px;
        margin-left: 3px;
    }

    .cart-cart-button {
        width: 100%;
        height: 54px;
        color: #ffffff;
        background-color: #F08C1E;
        border-radius: 3px;
        font-size: 18px;
        display: block;
        padding: 12px;
        text-align: center;
        margin-bottom: 20px;
    }

    .cart-cart-button:hover, .cart-cart-button:visited {
        color: #ffffff; text-decoration: none;
    }

    .cart-cart-button i {
        background-image: url(/images/icons/cart.svg);
        width: 24px;
        height: 24px;
        display: inline-block;
        background-repeat: no-repeat;
        background-position: center center;
        margin-right: 8px;
        overflow: hidden;
        vertical-align: sub;
    }

    .cart-actions {
        margin-bottom: 30px;
    }

    .cart-actions-link {
        background-color: #FCFCFC;
        border: 1px solid #B3B3B3;
        border-radius: 30px;

        display: inline-block;
        font-size: 13px;
        height: 54px;
        width: 127px;
        padding-left: 36px;
    }

    .cart-actions-link, .cart-actions-link:visited {
        color: #333333;
        text-decoration: none;
    }

    .cart-actions-link:hover {
        color: #333333;
        text-decoration: underline;
    }

    .cart-action-span-favorite {
        display: inline-block;
        line-height: 15px;
        padding-top: 12px;
    }

    .cart-action-span-point {
        display: inline-block;
        line-height: 18px;
        padding-top: 18px;
    }

    .cart-action-link-favorite {
        background-image: url("/images/icons/list2.svg");
        background-size: 18px 18px;
        background-repeat: no-repeat;
        background-position: 13px 18px;
    }

    @media (max-width: 1200px) {
        .cart-action-link-favorite {
            float: right;
        }
    }

    .cart-action-link-point {
        background-image: url("/images/icons/point2.svg");
        background-size: 18px 18px;
        background-repeat: no-repeat;
        background-position: 12px 18px;
        /*margin-left: 12px;*/
    }

    .cart-seller-links {
        margin-bottom: 22px;
    }

    .cart-seller-link {
        font-size: 14px;
        margin-right: 28px;
        text-decoration: underline;
    }

    @media (max-width: 1200px) {
        .cart-seller-links {
            font-size: 12px;
        }
        .cart-seller-link {
            font-size: 12px;
            margin-right: 18px;
        }
    }

    .cart-seller-link, .cart-seller-link:hover, .cart-seller-link:visited {
        color: #666666;
    }

    .cart-seller-link:hover {
        text-decoration: none;
    }

    .cart-seller-sns-link img {
        width: 22px; height: 22px;
    }

    .cart-seller-block {
        background-color: #F5F5F5;
        border-radius: 3px;
        padding: 20px 27px;
        margin-bottom: 12px;
    }

    .cart-seller-block-title {
        font-size: 13px;
        margin-bottom: 10px;
    }

    .cart-seller-block-image-container {
        text-align: center;
    }
    .cart-seller-block-image-container img {
        width: 100%;
        border-radius: 50%;
        min-width: 64px;
    }

    .cart-seller-block-content-title {
        font-size: 18px;
        margin-bottom: 12px;
        overflow: hidden;
        display: block;
        -webkit-line-clamp: 1;
        word-break: break-word;
        text-overflow: ellipsis;
        display: -webkit-box;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }

    .cart-seller-block-content-level {
        font-size: 12px;
        margin-bottom: 8px;
    }

    .cart-seller-block-link {
        font-size: 13px;
        color: #666666;
        text-decoration: underline;
    }

    .cart-seller-block-link:hover {
        text-decoration: none;
        color: #666666;
    }

    .cart-seller-block-link:visited {
        color: #666666;
    }

    .cart-seller-follower-button {
        margin-top: 12px;
        font-size: 13px;
        color: #333333;
        line-height: 17px;
        padding-top: 11px;
        padding-bottom: 11px;
        background-color: #ffffff;
        border: 1px solid #B3B3B3;
        border-radius: 30px;
        width: 100%;
        display: inline-block;
        text-align: center;
        min-width: 140px;
    }

    .cart-seller-follower-button:hover {
        color: #333333;
    }

    .cart-seller-follower-button:visited {
        color: #333333;
    }

    .cart-seller-follower-button i {
        background-image: url("/images/icons/user.svg");
        width: 15px;
        height: 15px;
        display: inline-block;
        vertical-align: sub;
        background-repeat: no-repeat;
    }

    .cart-seller-product-link {
        text-align: right; font-size: 15px;
        margin-bottom: 30px;
    }

    .cart-seller-product-link a {
        color: #333333; text-decoration: underline;
    }

    .cart-seller-product-link a:hover, .cart-seller-product-link a:visited {
        color: #333333;
    }

    .cart-seller-product-link a:hover {
        text-decoration: none;
    }

    .cart-seller-desc {
        color: #333333;
        font-size: 13px;
        padding: 0 6px;
        line-height: 18px;
        margin-bottom: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }

    .cart-seller-minimize-desc {
        height: 36px;
        -webkit-line-clamp: 2;
    }

    .cart-seller-desc-more-link {
        text-align: right;
        position: relative;
        padding-right: 18px;
    }

    .cart-seller-desc-more-link a, .cart-seller-desc-more-link a:hover, .cart-seller-desc-more-link a:visited {
        color: #333333; text-decoration: none;
    }
    .more-link-icon {
        display: block;
        position: absolute;
        top: 8px;
        right: 0;
        bottom: 0;
        width: 8px;
        height: 8px;
        border-right: 2px solid #363636;
        border-bottom: 2px solid #363636;
        transform: translateY(-2px) rotate(45deg);
        transition: transform 0.2s ease;
    }

    .less-link-icon {
        display: block;
        position: absolute;
        top: 11px;
        right: 0;
        bottom: 0;
        width: 8px;
        height: 8px;
        border-right: 2px solid #363636;
        border-bottom: 2px solid #363636;
        transform: translateY(-2px) rotate(-135deg);
        transition: transform 0.2s ease;
    }

    .cart-seller-desc-container {
        margin-bottom: 30px;
    }

    .cart-seller-review-container {
        color: #333333;
    }

    .cart-seller-review-title {
        font-size: 16px; margin-bottom: 16px;
    }

    .cart-seller-review-rating {
        margin-bottom: 12px;
    }
    .cart-seller-review-rating label {
        font-size: 13px; margin-left: 12px;
    }

    .cart-seller-review-comment-title {
        font-size: 13px; margin-bottom: 12px;
    }

    .cart-seller-review-comment-button {
        text-align: right; padding-right: 16px;
        margin-top: 15px;
    }

    .cart-seller-review-comment-button input[type=submit] {
        border-radius: 3px;
        font-size: 16px;
        line-height: 20px;
        padding: 9px;
        background-color: #F9F9F9;
        border: 1px solid #B3B3B3;
        color: #333333;

    }

    .cart-relation-container {
        padding: 50px 0;
        background: transparent;
    }

    .cart-relation-container.even {
        background-color: #F7F7F7;
    }


    .cart-section-item {
        padding-left: 15px;
    }

    .cart-section-item h2 {
        font-size: 22px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .cart-section-item {
            margin-bottom: 40px;
            overflow: hidden;
            padding-bottom: 5px;
            border-bottom: 1px solid #B3B3B3;
            padding-left: 8px;
            padding-right: 8px;
        }

        .cart-section-item:last-child {
            border-bottom: none;
        }

        .cart-section-item h2 {
            font-size: 16px;
        }
    }

    .cart-section-item h2 span.cart-section-item-link {
        float: right;
        font-size: 16px;
        margin-top: 8px;
        margin-right: 30px;
    }

    .cart-section-item h2 span.cart-section-item-link a {
        color: #000;
        text-decoration: underline;
    }

    .cart-section-item h2 span.cart-section-item-link a:hover,
    .cart-section-item h2 span.cart-section-item-link a:visited {
        color: #000;
    }

    .cart-section-item h2 span.cart-section-item-link a:hover {
        text-decoration: none;
    }



    @media (max-width: 768px) {
        .cart-section-item h2 span.cart-section-item-link {
            margin-right: 18px;
            margin-top: 5px;
            font-size: 13px;
        }

        .cart-section-item h2 span.cart-section-item-link a {
            text-decoration: none;
        }

        .cart-section-item h2 span.cart-section-item-link a:after {
            content: '>';
            margin-left: 8px;
            font-size: 13px;
        }
    }

    .container-relation {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        overflow: hidden;
    }

    @media (min-width: 1400px) {
        .container-relation {
            max-width: 1380px;
        }
    }

    .container-inner-relation {
        margin-left: auto;
        margin-right: auto;

    }

    #cart-wrapper {
        padding-bottom: 250px;
        position: relative;
    }

    .cart-list-items {
        width: 815px;
        padding-left: 15px;
        margin-bottom: 24px;
    }

    .cart-list-buttons {
        width: 320px;
        padding-left: 20px;
    }

    .cart-list-items-container {
        box-shadow: 0 0 3px rgb(0 0 0 /20%);
        border-radius: 5px;
        border-color: #FeFeFe;
    }


    .cart-list-items-header {
        border-bottom: 1px solid rgb(0 0 0 / 10%);
        padding: 14px 40px 12px 27px;
        overflow: hidden;
    }

    .cart-list-items-header .title {
        font-size: 14px;
        float: left;
        font-weight: bold; margin-bottom: 0;
    }

    .cart-list-items-header .point {
        font-size: 14px; float: right;
        font-weight: bold; margin-bottom: 0;
        background-image: url(/images/icons/point2.svg);
        background-repeat: no-repeat;
        padding-left: 20px;
    }

    .cart-list-items-body {
        padding: 30px 20px;
        overflow: hidden;
    }

    .cart-list-item+.cart-list-item {
        margin-top: 30px;
    }
    .cart-list-item-image-container {
        width: 130px;
        float: left;
    }

    .cart-list-item-image-container img {
        width: 100%;
    }

    .cart-list-item-container {
        padding-left: 160px;
    }

    .cart-list-item-content {
        width: 440px; float: left;
    }

    .cart-list-item-content .title {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .cart-list-item-content .user img {
        width: 20px; height: 20px;
        border-radius: 10px;
    }

    .cart-list-item-content .user a {
        color: #919191;
        text-decoration: underline;
        font-size: 13px;
    }

    .cart-list-item-content .user a:hover {
        text-decoration: none;
    }

    .cart-list-item-content .delete {
        float: right;
    }

    .cart-list-item-content .delete a {
        color: #919191;
        text-decoration: none;
        font-size: 14px;
    }

    .cart-list-item-content .delete a:hover {
        text-decoration: underline;
    }




    .cart-list-item-point {
        /*margin-right: 5px; */
        float: right;
        margin-top: 50px; font-weight: bold;
        font-size: 18px;
    }

    .cart-list-item-point span {
        font-size: 14px;
        margin-left: 4px;
    }

    .cart-list-items-footer {
        border-top: 1px solid rgb(0 0 0 / 10%);
        padding: 12px 40px 14px 27px;
        overflow: hidden;
    }

    .cart-list-items-footer .total {
        float: right;
        font-size: 17px;
    }
    .cart-list-items-footer .total span.price {
        font-weight: bold;
        font-size: 20px;
    }

    .cart-list-buttons-container {
        box-shadow: 0 0 3px rgb(0 0 0 /20%);
        border-radius: 5px;
        border-color: #FeFeFe;

    }

    .cart-list-buttons-container .main {
        padding: 18px;
        border-bottom: 1px solid rgb(0 0 0 / 10%);
    }

    .cart-main-button {
        color: white;
        width: 100%;
        font-size: 18px;
        text-align: center;
        padding-top: 13px; padding-bottom: 13px;
        border: none;
        border-radius: 5px;
        background-color: #49A1DC;
    }

    .cart-main-button:hover {
        opacity: 0.5;
    }

    .cart-list-buttons-container .main .total {
        margin-top: 18px;
        text-align: center;
        font-size: 17px;
    }
    .cart-list-buttons-container .main .total span.price {
        font-weight: bold;
        font-size: 20px;
    }

    .cart-list-buttons-container .sub {
        padding: 10px 18px;
    }

    .cart-sub-button {
        width: 100%;
        font-size: 16px;
        text-align: center;
        padding-top: 8px; padding-bottom: 8px;
        border: none;
        border-radius: 5px;
        background-color: #E1E1E1;
        color: black;
        display: inline-block;
        cursor: pointer;
        text-decoration: none;
    }

    .cart-sub-button:hover {
        text-decoration: none;
        color: black;
        opacity: 0.5;
    }

    .cart-sub-button+.cart-sub-button {
        margin-top: 10px;
    }

    .cart-page-title .title {
        margin-top: 15px;
        float: left;
    }
    .cart-page-title .status {
        float: right;
        width: 300px;
        height: 75px;
    }

    @media (max-width: 768px) {
        .cart-page-title .title {
            float: none;

        }

        .cart-page-title .status {
            float: none;
            margin: 30px auto 0 auto;
        }

    }

    .cart-page-title .status ul {
        padding: 60px 0 0 0 !important;
        margin-left: -12px; margin-right: -20px;
    }

    .cart-page-title .status ul li {
        list-style: none; float: left; font-size: 13px;
    }

    .cart-page-title .status ul li+li {
        margin-left: 88px;
    }

    .cart-page-title .step-1 {
        background-image: url(/images/icons/cart/step1.svg);
        background-repeat: no-repeat;
    }

    .cart-page-title .step-2 {
        background-image: url(/images/icons/cart/step2.svg);
        background-repeat: no-repeat;
    }

    .cart-page-title .step-3 {
        background-image: url(/images/icons/cart/step3.svg);
        background-repeat: no-repeat;
    }

    @media (max-width: 1200px) {
        .cart-list-items {
            width: 640px;
        }

        .cart-list-buttons {
            width: 320px;
            padding-left: 20px;
        }

        .cart-list-item-content {
            width: 300px;
        }
    }


    @media (max-width: 992px) {
        .cart-list-items {
            width: 70%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .cart-list-buttons {
            width: 30%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .cart-list-item-content {
            width: auto;
        }

        .cart-list-item-point {
            margin-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .cart-list-items {
            width: 100%;
        }

        .cart-list-buttons {
            width: 100%;
        }
    }

    .cart-section-item h2 span.cart-section-item-link {
        float: right;
        font-size: 16px;
        margin-top: 8px;
        margin-right: 30px;
    }

    .cart-section-item h2 span.cart-section-item-link a {
        color: #000;
        text-decoration: underline;
    }

    .cart-section-item h2 span.cart-section-item-link a:hover,
    .cart-section-item h2 span.cart-section-item-link a:visited {
        color: #000;
    }

    .cart-section-item h2 span.cart-section-item-link a:hover {
        text-decoration: none;
    }



    @media (max-width: 768px) {
        .cart-section-item h2 span.cart-section-item-link {
            margin-right: 18px;
            margin-top: 5px;
            font-size: 13px;
        }

        .cart-section-item h2 span.cart-section-item-link a {
            text-decoration: none;
        }

        .cart-section-item h2 span.cart-section-item-link a:after {
            content: '>';
            margin-left: 8px;
            font-size: 13px;
        }
    }

</style>