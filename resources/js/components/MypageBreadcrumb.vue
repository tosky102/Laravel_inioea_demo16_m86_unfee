<template>
    <div class="mypage-breadcrumb">

        <div v-for="(item,index) in breadcrumb" class="mypage-breadcrumb-item">
            <a :href="item.url" v-if="index != Object.keys(breadcrumb).length - 1">{{ item.text }}</a>
            <span v-if="index == Object.keys(breadcrumb).length - 1">{{ item.text }}</span>
        </div>
        <div class="clearfix"></div>
    </div>
</template>
<script>

    export default {
        props: ['breadcrumbs'],
        data() {
            return {
                breadcrumb: JSON.parse(this.breadcrumbs),
            }
        },
    }
</script>
<style>
    .mypage-breadcrumb {
        font-size: 14px;
        margin-bottom: 20px;
    }

    .mypage-breadcrumb-item {
        float: left; margin-right: 15px;
    }

    .mypage-breadcrumb a {
        text-decoration: none;
    }

    .mypage-breadcrumb a:hover {
        text-decoration: underline;
    }

    .mypage-breadcrumb a, .mypage-breadcrumb a:hover, .mypage-breadcrumb a:visited, .mypage-breadcrumb span {
        color: #969696;
    }


    .mypage-breadcrumb .mypage-breadcrumb-item+.mypage-breadcrumb-item:before {
        content: '>';
        margin-right: 15px;
        color: #969696;
    }

    @media (max-width: 768px) {
        .mypage-breadcrumb {
            display: none;
        }
    }
</style>