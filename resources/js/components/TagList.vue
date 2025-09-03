<template>
    <div class="list-page-wrapper">
        <div class="tag-list-container">
            <list-breadcrumb :breadcrumbs="breadcrumbs"></list-breadcrumb>
            <h2 class="list-page-title">
                {{ title }}
            </h2>

            <h2 class="sp-list-page-title">
                {{ title }}
            </h2>

            <ul class="tag-list">
                <li v-for="item in tag" class="">
                    <a :href="item.url">{{ item.text}}</a>
                </li>
            </ul>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['breadcrumbs', 'title', 'tags'],
        data() {
            return {
                tag: JSON.parse(this.tags),
            }
        },

    }
</script>

<style>
    .list-page-wrapper {
        width: 100%;
    }

    .tag-list-container {
        padding: 0 40px;
    }

    @media (max-width: 768px) {
        .list-page-title {
            display: none;
        }

        .tag-list-container {
            padding: 0 15px;
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

    ul.tag-list {
        padding: 0;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    ul.tag-list li {
        margin: 0 8px 8px 0;
        display: inline-block;
        height: 36px;
        max-width: 100%;
    }

    ul.tag-list li:before {
        content: "";
        display: table;
    }

    ul.tag-list li:after {
        clear: both;
    }

    ul.tag-list li a {
        border: solid 1px #475558;
        border-radius: 4px;
        color: #222222;
        font-size: 12px;
        display: flex;
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        padding: 8px;
        white-space: nowrap;
        display: block;
    }

    ul.tag-list li:last-child {
        margin-bottom: 0;
    }

</style>