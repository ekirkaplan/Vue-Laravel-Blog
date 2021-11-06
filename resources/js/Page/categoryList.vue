<template>
    <div class="container">

        <div class="row">
            <div class="col-12 mt-5">
                <h1>{{ categoryData.name }}</h1>
            </div>
        </div>

        <hr>
        <div class="row"  >
            <div class="col-12">
                <div v-if="renderComponent" id="blog" class="grid-layout post-2-columns m-b-30" data-item="post-item">

                    <div class="post-item border" v-for="blog in categoryData.blogList">
                        <div class="post-item-wrap">
                            <div class="post-image">
                                <router-link :to="'/yazi/'+blog.slug">
                                    <img alt="" :src="blog.img">
                                </router-link>
                            </div>
                            <div class="post-item-description">
                                <span class="post-meta-date"><i class="fa fa-calendar-o"></i>{{blog.streamDate}}</span>
                                <span class="post-meta-comments">
                                    <router-link  :to="'/yazi/'+blog.slug"><i class="fa fa-comments-o"></i>{{ blog.commentsCount }} Yorum</router-link>
                                </span>
                                <h2><a href="#">{{blog.name}}</a></h2>
                                <p>{{blog.contentShort}}</p>
                                <router-link :to="'/yazi/'+blog.slug" class="item-link">Devamını Oku<i class="icon-chevron-right"></i></router-link>
                            </div>
                        </div>
                    </div>

                </div>
                <img class="loadGif" src="/Gallery/load.gif" v-else alt="">
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "categoryList",
    data() {
        return {
            categoryData: {},
            renderComponent: true,
            title: "",

        }
    },
    methods: {
        categoryGet() {
            const slug = this.$route.params.slug;
            axios.get('/api/category/find/'+slug).then((res) => {
                this.categoryData = res.data.data
                this.title = res.data.data.name
            }).catch((err) => {
                console.log(err);
            });
        },
        forceRerender() {
            // Remove my-component from the DOM
            this.renderComponent = false;

            this.$nextTick(() => {
                // Add the component back in
                this.renderComponent = true;
            });
        }
    },
    created() {
        this.categoryGet();
        this.$unloadScript("/js/functions.js");
    },
    mounted() {

        setTimeout(() => {
            this.$loadScript("/js/functions.js")
        },1000);
    },
    updated() {
        this.$nextTick( () => {
            this.$unloadScript("/js/functions.js");
            $(document).trigger("ready")
            setTimeout(() => {
                this.$loadScript("/js/functions.js")
                console.log("asdasd")
            },1000);
        })
    },
    watch: {
        $route(to, from) {
            this.categoryGet();
            this.forceRerender()
        }
    },
    head: {
        title: function () {
            return {
                inner: "Blog Yazıları"
            }
        }
    }
}
</script>

<style scoped>
.loadGif {
    width: auto;
    margin: 0 auto;
}
</style>
