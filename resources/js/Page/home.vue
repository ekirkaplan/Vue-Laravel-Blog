<template>
    <div class="">

        <!-- End Row -->

       <section  id="page-content">
           <div class="container" >
               <div class="row" v-for="(item, index) in categoryList" >
                   <div class="col-12">
                       <div class="card">
                           <div class="card-body">
                               <h3>{{ item.name }}</h3>
                               <hr>
                               <div :id="'blog'+index" class="grid-layout post-2-columns m-b-30" data-item="post-item">

                                   <div class="post-item border" v-for="blog in item.blogList">
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
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </section>


    </div>
</template>

<script>
export default {
    name: "home",
    data() {
        return {
            categoryList: [],
            sliderList: [],
        }
    },
    methods: {
        categoryGet() {
            axios.get('/api/category/blog-with-list').then((res) => {
                this.categoryList = res.data.data
            }).catch((err) => {
                console.log(err);
            });
        },
        sliderGet() {
            axios.get('/api/blog/slider-list').then((res) => {
                this.sliderList = res.data.data
            }).catch((err) => {
                console.log(err);
            });
        }
    },
    created() {
        this.categoryGet();
        this.sliderGet();

    },
    updated() {
        this.$nextTick( () => {
            this.$unloadScript("/js/functions.js");
            $(document).trigger("ready")
            this.$loadScript("/js/functions.js")
        })
    },
    mounted() {
        setTimeout(() => {
            this.$loadScript("/js/functions.js")
        },1000)
    },
    head: {
        title: function () {
            return {
                inner: "Anasayfa | Vue Laravel Blog Project"
            }
        }
    }
}
</script>

<style scoped>
.sliderTextContent {
    position: absolute;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 15;
}

.owl-bg-img:after {
    content: " ";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
}
</style>
