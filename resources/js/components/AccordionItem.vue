<template>
    <div>
        <div :id="groupId + '-' + item.id" class="accordion-item" :class="{'is-active': item.active}" v-if="multiple">
            <dt class="accordion-item-title" @click="toggle">
                <button class="accordion-item-trigger">
                    <h4 class="accordion-item-title-text"><a :href="item.url">{{item.title}}</a></h4>
                    <span class="accordion-item-trigger-icon" ></span>
                </button>
            </dt>
            <transition
                    name="accordion-item"
                    @enter="startTransition"
                    @after-enter="endTransition"
                    @before-leave="startTransition"
                    @after-leave="endTransition">
                <dd v-if="item.active" class="accordion-item-details">
                    <div class="accordion-item-details-inner">
                        <ul class="accordion-sub-item">
                            <li v-for="subitem in item.details">
                                <a :href="subitem.url">
                                    <div>{{ subitem.text }}</div>
                                    <span class="accordion-sub-item-trigger-icon"></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </dd>
            </transition>
        </div>

        <div v-else>
            <dt class="accordion-item-title">
                <button @click="goToLink" class="accordion-item-trigger">
                    <h4 class="accordion-item-title-text">{{item.title}}</h4>
                    <span class="accordion-sub-item-trigger-icon"></span>
                </button>
            </dt>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item', 'multiple', 'groupId'],
        methods: {
            toggle(event) {
                if (this.multiple) this.item.active = !this.item.active
                else {
                    this.$parent.$children.forEach((item, index) => {
                        if (item.$el.id === event.currentTarget.parentElement.parentElement.id) item.item.active = !item.item.active
                        else item.item.active = false
                    })
                }
            },

            goToLink(event) {
                location.href = this.item.url;
            },
            startTransition(el) {
                el.style.height = el.scrollHeight + 'px'
            },

            endTransition(el) {
                el.style.height = ''
            }
        },
    }
</script>

<style>

    .accordion-item-trigger {
        padding: 12px 10px;
        background-color: white;
    }

    .accordion-item-details-inner {
        overflow: hidden;
        font-size: 13px;
        /*border-top: 1px solid rgba(10, 10, 10, 0.1);*/
        /*border-left: 1px solid rgba(10, 10, 10, 0.1);*/
    }

    .accordion-item-title {
        position: relative;
    }
    .accordion-item-title h4 {
        font-size: 13px;
        margin-bottom: 0;
        padding-right: 1.25rem;
    }

    .accordion-item-trigger {
        width: 100%;
        text-align: left;
        /*background-color: transparent;*/
        border: none;
        margin: 2px 0;
    }

    .accordion-item-trigger-icon {
        display: block;
        position: absolute;
        top: 0;
        right: 1.25rem;
        bottom: 0;
        margin: auto;
        width: 8px;
        height: 8px;
        border-right: 2px solid #363636;
        border-bottom: 2px solid #363636;
        transform: translateY(-2px) rotate(45deg);
        transition: transform 0.2s ease;
    }
    .is-active .accordion-item-trigger-icon {
        transform: translateY(2px) rotate(225deg);
    }

    .accordion-item-details {
        overflow: hidden;
        background-color: whitesmoke;
        margin-bottom: 0;
        border-radius: 0;
    }

    .accordion-item-enter-active, .accordion-item-leave-active {
        will-change: height;
        transition: height 0.2s ease;
    }

    .accordion-item-enter, .accordion-item-leave-to {
        height: 0 !important;
    }

    .accordion-sub-item {
        padding: 0;
    }
    .accordion-sub-item li {
        list-style: none;
        float: left;
        padding: 10px 0;
        position: relative;
        padding-right: 24px;
        margin: 1px 0;
        background-color: white;
        width: 146px;
    }

    .accordion-sub-item li:nth-child(odd) {
        margin-right: 1px;
    }

    .accordion-sub-item li:nth-child(even) {
        margin-left: 1px;
    }

    .accordion-sub-item li a {
        font-size: 13px;
        color: black;
    }
    .accordion-sub-item li a:hover,
    .accordion-sub-item li a:focus {
        color: black;
    }

    .accordion-sub-item li a div {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        width: 100px;
        margin-left: 20px;
        border: none !important;
    }

    .accordion-sub-item-trigger-icon {
        display: block;
        position: absolute;
        top: 0;
        right: 1.25rem;
        bottom: 0;
        margin: auto;
        width: 8px;
        height: 8px;
        border-right: 2px solid #363636;
        border-bottom: 2px solid #363636;
        transform: translateY(-2px) rotate(-45deg);
        transition: transform 0.2s ease;
    }

    .accordion-item-title-text a,
    .accordion-item-title-text a:hover {
        text-decoration: none; color: black;
    }
</style>