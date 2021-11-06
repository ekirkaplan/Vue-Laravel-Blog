<template>
    <header id="header" class="dark">
        <div class="header-inner">
            <div class="container">
                <!--Logo-->
                <div id="logo">
                    <router-link to="/">
                        <span class="logo-default">Blog</span>
                        <span class="logo-dark">Blog</span>
                    </router-link>
                </div>
                <!--End: Logo-->
                <!--Navigation-->
                <div id="mainMenu">
                    <div class="container">
                        <nav>
                            <ul>
                                <li><router-link to="/">Anasayfa</router-link></li>
                                <li><router-link to="/tum-yazilar">Tüm Yazılar</router-link></li>
                                <li v-for="item in categoryList"><router-link :to="'/kategori/'+item.slug">{{item.name}}</router-link></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--end: Navigation-->
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "header",
    data() {
        return {
            categoryList: [],
            renderComponent: true,
        }
    },
    methods: {
        categoryGet() {
            axios.get('/api/category/menu-list').then((res) => {
                this.categoryList = res.data
            }).catch((err) => {
                console.log(err);
            });
        },
    },
    created() {
        this.categoryGet()
    },

}
</script>

<style scoped>
.router-link-exact-active {
    color: #0a83ff !important;
}
</style>
