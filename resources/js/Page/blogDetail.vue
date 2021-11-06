<template>
    <section id="page-content" >
        <div class="container">
            <div class="row" style="justify-content: center;">
                <!-- content -->
                <div class="content col-lg-9">
                    <!-- Blog -->
                    <div id="blog" class="single-post">
                        <!-- Post single item-->
                        <div class="post-item">
                            <div class="post-item-wrap">
                                <div class="post-image">
                                    <a href="#">
                                        <img alt="" :src="blogData.img">
                                    </a>
                                </div>
                                <div class="post-item-description">
                                    <h2>{{blogData.name}}</h2>
                                    <div class="post-meta">
                                        <span class="post-meta-date"><i class="fa fa-calendar-o"></i>Yayın Tarihi{{blogData.streamDate}}</span>
                                        <span class="post-meta-comments"><a href="javascript:void(0)"><i class="fa fa-comments-o"></i>{{blogData.commentsCount}} Yorum</a></span>
                                        <span class="post-meta-category"><a href="javascript:void(0)"><i class="fa fa-tag"></i><strong v-for="category in blogData.category">{{category.name}}, </strong></a></span>
                                    </div>
                                    <div v-html="blogData.content"></div>
                                </div>
                                <div class="post-tags">
                                    <router-link v-for="category in blogData.category" :to="'/kategori/'+category.slug">
                                        {{ category.name }}</router-link>
                                </div>
                                <!-- Comments -->
                                <div class="comments" id="comments">
                                    <div class="comment_number">
                                        Yorumlar <span>({{blogData.commentsCount}})</span>
                                    </div>
                                    <div class="comment-list">
                                        <!-- Comment -->
                                        <div class="comment" v-for="comment in blogData.comments">
                                            <div class="image"><img alt="" src="/Gallery/logo-circle.png" class="avatar"></div>
                                            <div class="text">
                                                <h5 class="name">{{comment.name}}</h5>
                                                <span class="comment_date">Yorum Tarihi: {{comment.createdAt}}</span>
                                                <div class="text_holder">
                                                    <p>{{comment.content}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end: Comment -->
                                    </div>
                                </div>
                                <!-- end: Comments -->
                                <div class="respond-form" id="respond">
                                    <div class="respond-comment">
                                        Siz de Bir <span>Yorum Yapın</span></div>
                                    <form class="form-gray-fields">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="upper" for="name">İsim</label>
                                                    <input class="form-control required" :class="{'is-invalid' : commentValidate.nameStatus}" v-model="commentData.name" name="senderName" placeholder="İsminiz" id="name" aria-required="true" type="text">
                                                    <small class="invalid-feedback" v-if="commentValidate.nameStatus">{{commentValidate.nameMessage}}</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="upper" for="email" >Email</label>
                                                    <input class="form-control required email" :class="{'is-invalid' : commentValidate.emailStatus}" v-model="commentData.email" name="senderEmail" placeholder="E-Posta Adresiniz" id="email" aria-required="true" type="email">
                                                    <small class="invalid-feedback" v-if="commentValidate.emailMessage">{{commentValidate.emailMessage}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="upper" for="comment">Yorumunuz</label>
                                                    <textarea class="form-control required" :class="{'is-invalid' : commentValidate.contentStatus}" v-model="commentData.contents" name="comment" rows="9" placeholder="Yorumunuz" id="comment" aria-required="true"></textarea>
                                                    <small class="invalid-feedback" v-if="commentValidate.contentStatus">{{commentValidate.contentMessage}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group text-center">
                                                    <button @click="commentSend" :disabled="buttonDisable" class="btn" type="button">Yorumu Gönder</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end: Post single item-->
                    </div>
                </div>
                <!-- end: content -->
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "blogDetail",
    data() {
        return {
            blogData: {},
            buttonDisable: false,
            commentData: {
                name: "",
                email: "",
                contents: "",
                blogId: "",
            },
            commentValidate: {
                nameStatus: 0,
                nameMessage: "",
                emailStatus: 0,
                emailMessage: "",
                contentStatus: 0,
                contentMessage: "",
            }
        }
    },
    methods: {
        detail() {
            const slug = this.$route.params.slug;
            axios.get('/api/blog/detail-get/'+slug).then((res) => {
                this.blogData = res.data.data
            }).catch((err) => {
                console.log(err);
            });
        },
        commentSend()
        {
            function validateEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            /* Validate */
            const nameLennght = this.commentData.name.length;
            if (nameLennght > 2){
                this.commentValidate.nameStatus = 0;
            }else {
                this.commentValidate.nameStatus = 1;
                this.commentValidate.nameMessage = "İsim Girmediniz!";
            }
            if (validateEmail(this.commentData.email)){
                this.commentValidate.emailStatus = 0;
            }else {
                this.commentValidate.emailStatus = 1;
                this.commentValidate.emailMessage = "Doğru E-Posta Adresi Giriniz";
            }
            const contentsLength = this.commentData.contents.length;
            if (contentsLength > 20){
                this.commentValidate.contentStatus = 0;
            }else {
                this.commentValidate.contentStatus = 1;
                this.commentValidate.contentMessage = "Mesajınız En Az 20 Karakter Olmalıdır";
            }
            /* Validate */
            const status = this.commentValidate.contentStatus + this.commentValidate.nameStatus + this.commentValidate.emailStatus;
            if (status < 1){
                this.buttonDisable = true;
                this.commentData.blogId = this.blogData.id;
                const sendData = this.commentData;
                axios.post('/api/blog/comment-add/',sendData).then((res) => {
                    if (res.data.statusCode > 0){
                        alert(res.data.statusMessage)
                        this.buttonDisable = true;
                    }else {
                        alert(res.data.statusMessage)
                        this.buttonDisable = false;
                    }
                }).catch((err) => {
                    console.log(err);
                });
            }
        }
    },
    created() {
        this.detail();
    },
    head: {
        title: function () {
            return {
                inner: this.blogData.name
            }
        }
    }
}
</script>

<style scoped>

</style>
