<template>
    <div class="card mt-2 p-5">
        <div v-if="authUser">
            <input @keypress.enter="addComment" v-model="body" type="text" class="form-control form-control-sm w-80">
            <button @click="addComment"  class="btn btn-sm btn-primary mr-2 mt-2">
                <small>Add comment</small>
            </button>
        </div>

        <comment @addNewReply="handleAddNewReply" v-for="(comment, index) in comments" :comment="comment" :key="index"></comment>
        <div class="text-center">
            <button v-if="this.dataPagination.next_page_url" @click="loadMore" class="btn btn-success">
                Load more
            </button>
            <span v-else>
                No more comment to show
            </span>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Replies from "./Replies";
import Comment from './Comment'
export default {
    name: "ListComment",
    components: {Avatar, Replies, Comment},
    props: [
        'videoId'
    ],
    data() {
        return {
            dataPagination: {},
            comments:[],
            isAddComment: false,
            body:''
        }
    },
    mounted() {
        this.fetchComment()
    },
    methods:{
        fetchComment() {
            const pageUrl = this.dataPagination.next_page_url ?? `/videos/${this.videoId}/comments`
            axios.get(pageUrl)
                .then(res => {
                    this.dataPagination = res.data.data
                    this.comments.push(...res.data.data.data)
                })
        },
        loadMore() {
            this.fetchComment()
        },
        // handleAddComment(comment){
        //     this.comments.unshift(comment)
        // },
        handleAddNewReply(data){
            this.comments = this.comments.map(comment => {
                if (data.comment_id === comment.id) {
                    comment.replies_count += 1
                }
                return comment
            })
        },
        addComment(){
            if (!this.body) {
                return alert('Please enter the comment')
            }
            axios.post(`/videos/comments/store`, {body: this.body, video_id: this.videoId})
                .then(res => {
                    // this.$emit('addComment', res.data.data)
                    this.comments.unshift(res.data.data)
                    this.body = ''
                })

        }
    },
    computed:{
        authUser(){
            return authUser
        }
    }
}
</script>

<style scoped>

</style>
