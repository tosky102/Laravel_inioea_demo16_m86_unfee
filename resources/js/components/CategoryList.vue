<template>
    <div class="list-page-wrapper" ref="list_page_wrapper">
        <div class="list-page-content" ref="list_page_content" :style="{ width: suggestWidth + 'px' }">
            <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>
            <h2 class="list-page-title">
                {{ title }}
            </h2>

            <h2 class="sp-list-page-title">
                {{ title }}
            </h2>

            <div v-for="item in content" class="category-section-item">
                <h2>
                    {{ item.category }}
                    <span class="category-section-item-link"><a :href="item.category_url">もっと見る</a></span>
                </h2>

                <div class="sub-categories-list">
                    <a v-for="sub_category in item.sub_categories" :href="sub_category.url">{{ sub_category.text }}</a>
                </div>
                <div class="product-items-container">
                    <product-item v-for="(product, index) in item.products" :item="product" :key="index" v-if="index < itemsDisplay"></product-item>
                </div>
                <div class="clearfix"></div>
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        props: ['breadcrumbs', 'title', 'contents'],
        data() {
            return {
                content: JSON.parse(this.contents),
                suggestWidth: null,
                itemsDisplay: 0
            }
        },
        mounted() {
            this.handleResize();
        },
        methods: {
            handleResize() {
                let window_width = window.innerWidth;

                if (this.$refs.list_page_wrapper == undefined) return;

                if (window_width >= 768) {
                    let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
                    let iWidth = 210;
                    let suggestWidth = iWidth;
                    for (var i = 1; i < 100; i++) {
                        iWidth = 195 * i + 210;
                        if (iWidth >= wrapper_width) break;
                        suggestWidth = iWidth;
                    }
                    this.suggestWidth = suggestWidth;
                    this.itemsDisplay = i;
                } else {
                    let wrapper_width = this.$refs.list_page_wrapper.clientWidth;
                    this.suggestWidth = wrapper_width;
                    this.itemsDisplay = 4;
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

<style scoped>
    .list-page-wrapper {
        width: 100%;
    }

    .list-page-content {
        margin-left: auto;
        margin-right: auto;
        overflow: hidden;
    }

    .list-page-content {
        padding-left: 15px;
    }

    @media (max-width: 768px) {
        .list-page-title {
            display: none;
        }

        .list-page-content {
            padding-left: 8px;
        }
    }

    .list-page-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 60px;
    }


    .sp-list-page-title {
        display: none;
    }


    @media (max-width: 768px) {
        .sp-list-page-title {
            display: block;
            margin-top: 30px;
            margin-bottom: 45px;
            font-size: 22px;
        }
    }

    .category-section-item {
        margin-bottom: 27px;
    }

    .category-section-item h2 {
        font-size: 22px;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .category-section-item {
            margin-bottom: 40px;
            overflow: hidden;
            padding-bottom: 5px;
            border-bottom: 1px solid #B3B3B3;
            margin-left: -8px;
            padding-left: 8px;
        }

        .category-section-item:last-child {
            border-bottom: none;
        }

        .category-section-item h2 {
            margin-left: 15px;
        }
    }

    .category-section-item h2 span.category-section-item-link {
        float: right;
        font-size: 16px;
        margin-top: 8px;
        margin-right: 30px;
    }

    .category-section-item h2 span.category-section-item-link a {
        color: #000;
        text-decoration: underline;
    }

    .category-section-item h2 span.category-section-item-link a:hover,
    .category-section-item h2 span.category-section-item-link a:visited {
        color: #000;
    }

    .category-section-item h2 span.category-section-item-link a:hover {
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .category-section-item h2 span.category-section-item-link {
            margin-right: 18px;
            margin-top: 0;
        }

        .category-section-item h2 span.category-section-item-link a {
            text-decoration: none;
        }

        .category-section-item h2 span.category-section-item-link a:after {
            content: '>';
            margin-left: 12px;
            font-size: 20px;
        }
    }

    .sub-categories-list {
        margin-bottom: 12px;
    }

    .sub-categories-list a {
        color: #333333; text-decoration: underline; margin-right: 12px;
    }
</style>