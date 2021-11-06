<template>
    <section id="page-content" class="sidebar-right">
        <div class="container">
            <div class="row">
                <!-- post content -->
                <div class="content col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <h1>Blog - Sidebar Right</h1>
                        <div class="breadcrumb float-left">
                            <ul>
                                <li><a href="#">Anasayfa</a>
                                </li>
                                <li class="active"><a href="#">Tüm Yazılar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end: Page title -->
                    <!-- Blog -->
                    <div id="blog">

                        <div class="post-item border" v-for="blog in blogList">
                            <div class="post-item-wrap">
                                <div class="post-image">
                                    <router-link :to="'/yazi/'+blog.slug">
                                        <img alt="" :src="blog.img">
                                    </router-link>
                                </div>
                                <div class="post-item-description">
                                    <span class="post-meta-date"><i
                                        class="fa fa-calendar-o"></i>{{ blog.streamDate }}</span>
                                    <span class="post-meta-comments">
                                    <router-link :to="'/yazi/'+blog.slug"><i
                                        class="fa fa-comments-o"></i>{{ blog.commentsCount }} Yorum</router-link>
                                </span>
                                    <h2><a href="#">{{ blog.name }}</a></h2>
                                    <p>{{ blog.contentShort }}</p>
                                    <router-link :to="'/yazi/'+blog.slug" class="item-link">Devamını Oku<i
                                        class="icon-chevron-right"></i></router-link>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end: Blog -->
                    <!-- Pagination -->
                    <!-- end: Pagination -->
                </div>
                <!-- end: post content -->
                <!-- Sidebar-->
                <div class="sidebar sticky-sidebar col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Sıralama</h4>
                        <select v-model="filterData.orderBy" name="" class="form-control" id="">
                            <option value="1">Tarih Yeniden Eskiye</option>
                            <option value="2">Tarih Eskiden Yeniye</option>
                            <option value="3">İsim A-Z</option>
                            <option value="4">İsim Z-A</option>

                        </select>
                    </div>

                    <div class="widget">
                        <h4 class="widget-title">Kategori</h4>
                        <ul class="categoryList">
                            <li @click="filterData.categoryId = 0" :class="{'active' : filterData.categoryId == 0}">
                                Hepsi
                            </li>
                            <li v-for="item in categoryList" @click="filterData.categoryId = item.id"
                                :class="{'active' : filterData.categoryId == item.id}">{{ item.name }}
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- end: Sidebar-->
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "blogList",
    data() {
        return {
            filterData: {
                orderBy: 1,
                categoryId: 0,
            },
            categoryList: [],
            blogList: [],
        }
    },
    methods: {
        categoryGet() {
            axios.get('/api/category/all-list').then((res) => {
                this.categoryList = res.data
            }).catch((err) => {
                console.log(err);
            });
        },
        blogGet() {
            const filterDatas = this.filterData;
            axios.post('/api/blog/filter-list', filterDatas).then((res) => {
                this.blogList = res.data.data
            }).catch((err) => {
                console.log(err);
            });
        }
    },
    created() {
        this.categoryGet();
        this.blogGet();
    },
    watch: {
        filterData: {
            handler: function (data)  {
                this.blogGet();
            },
            deep: true,
        }
    },
    head: {
        title: function () {
            return {
                inner: "Tüm Yazılar"
            }
        }
    }
}
</script>

<style scoped>
.categoryList {
    list-style: none;
}

.categoryList li {
    border: 1px solid black;
    border-radius: 5px;
    padding: 10px;
    margin: 14px 0;
    text-align: center;
    font-size: 19px;
    font-weight: 600;
    cursor: pointer;
}

.categoryList li.active {
    border: 1px solid #0a83ff;
    color: white;
    background-color: #0a83ff;
}
</style>
