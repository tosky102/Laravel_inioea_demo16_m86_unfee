<template>
    <div class="pagination">
        <div class="pagination__inner">
            <a href="/search/?product=sale,free&amp;page=9" class="pagination__prev nuxt-link-active"><i class="icon font-arrow-left"></i></a>
            <a href="/search/?product=sale,free&amp;page=8" class="pagination__num nuxt-link-active">8</a>
            <a href="/search/?product=sale,free&amp;page=9" class="pagination__num nuxt-link-active">9</a>
            <a href="/search/?product=sale,free&amp;page=10" aria-current="page" class="pagination__num nuxt-link-exact-active nuxt-link-active current">10</a>
            <a href="/search/?product=sale,free&amp;page=11" class="pagination__num nuxt-link-active">11</a>
            <a href="/search/?product=sale,free&amp;page=12" class="pagination__num nuxt-link-active">12</a>
            <a href="/search/?product=sale,free&amp;page=11" class="pagination__next nuxt-link-active"><i class="icon font-arrow-right"></i></a>
        </div>
    </div>
</template>
<script>

    export default {
        props: ['pagination'],
        data() {
            return {
                arrayPagination: JSON.parse(this.pagination),
                startPg: null,
                endPg: null,
            }
        },
        mounted() {
            let currentPg = this.arrayPagination.currentPg;
            let total = this.arrayPagination.total;
            let count = this.arrayPagination.count;
            let maxPg = (total % count) == 0 ? Math.floor(total / count) : Math.floor(total / count) + 1;

            let startPg = 1;
            let endPg = maxPg;

            if (currentPg < 5) {
                startPg = 1;
                endPg = startPg + 8 > endPg ? endPg : startPg + 8;

            } else if (currentPg > maxPg - 4) {
                endPg = maxPg;
                startPg = endPg - 8 > 0 ? endPg - 8 : 1;
            } else {
                startPg = currentPg - 4;
                endPg = currentPg + 4;
            }

            this.startPg = startPg;
            this.endPg = endPg;
        },
    }
</script>
<style>
    .icon {
        display: inline-block;
        color: #333;
        vertical-align: middle;
    }

    .icon {
        position: relative;
        display: inline-block;
        width: 1em;
        height: 1em;
        overflow: hidden;
        font-size: 1em;
        text-align: left;
        text-indent: 100%;
        white-space: nowrap;
    }

    .icon:before {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        height: 100%;
        line-height: 1;
        text-align: center;
        text-indent: 0;
    }

    .font-arrow-left:before {
        content: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Cpath d='M29.84,35.46a1.14,1.14,0,0,1-.72-.24L9.33,21.09A1.35,1.35,0,0,1,8.78,20a1.33,1.33,0,0,1,.55-1.09L29.13,4.77a1.79,1.79,0,0,1,.76-.23A1.48,1.48,0,0,1,31,5.06a1.21,1.21,0,0,1,.27,1,1.26,1.26,0,0,1-.57.89L12.38,20l18.28,13A1.38,1.38,0,0,1,31,34.92,1.49,1.49,0,0,1,29.84,35.46Z' style='fill:%23333'/%3E%3C/svg%3E");
    }

    .font-arrow-right:before {
        content: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Cpath d='M10.07,35.51A1.47,1.47,0,0,1,9,35a1.23,1.23,0,0,1-.27-1,1.3,1.3,0,0,1,.57-.9L27.65,20,9.3,6.9A1.55,1.55,0,0,1,8.77,6,1.18,1.18,0,0,1,9,5a1.48,1.48,0,0,1,1.14-.55,1.14,1.14,0,0,1,.72.24L30.71,18.91A1.33,1.33,0,0,1,31.26,20a1.37,1.37,0,0,1-.55,1.1L10.84,35.29A2,2,0,0,1,10.07,35.51Z' style='fill:%23333'/%3E%3C/svg%3E");
    }

    .font-arrow-left, .font-arrow-right {
        margin-bottom: 2px;
    }

    .pagination {
        margin: 20px 0;
        font-size: 15px;
        text-align: center;
    }

    .pagination__inner {
        display: inline-block;
    }

    .pagination__num {
        display: inline-block;
        padding: 7px 20px;
    }

    .pagination__num.current {
        position: relative;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        padding: 8px 0 0;
        margin: 0 13px;
        color: #fff;
        background-color: #666;
        border-radius: 50%;
    }

    .pagination__num.current:hover {
        opacity: 1;
    }

    .pagination__next, .pagination__prev {
        vertical-align: middle;
    }

    .pagination__next .icon, .pagination__prev .icon {
        margin-bottom: 4px;
    }

    .pagination a {
        color: inherit;
    }

    .pagination .icon:first-child {
        margin-right: 42px;
    }

    .pagination .icon:last-child {
        margin-left: 42px;
    }

    .page-search .pagination {
        margin-bottom: 40px;
    }

    .page-search .pagination__inner {
        margin-top: -10px;
    }
</style>