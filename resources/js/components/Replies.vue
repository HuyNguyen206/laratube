<template>
    <div class="mt-3">
        <div v-for="(reply, indexR) in replies" :key="indexR" class="media mt-1">
            <a href="" class="mr-3">
                <avatar :size="30" :username="reply.user.name"></avatar>
            </a>
            <div class="media-body">
                <h6 class="mt-0">{{ reply.user.name }}</h6>
                <small>{{ reply.body }}</small>
                <div class="my-1 w-100">
                    <input type="text" class="form-control form-control-sm w-80">
                    <div class="d-flex align-items-center justify-content-start mt-2">
                        <button class="btn btn-sm btn-primary mr-2">
                            <small>Add comment</small>
                        </button>
                        <span class="text-muted">{{reply.created_at_human}}</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="text-center" >
            <button v-if="unreadRepliesCount || this.dataPagination.next_page_url" @click="loadMore" class="btn btn-success">
                {{unreadRepliesCount}} replies left
            </button>
        </div>
    </div>

</template>

<script>
import Avatar from 'vue-avatar'
export default {
    name: "Replies",
    props: ['comment'],
    components: {Avatar},
    data(){
        return {
            replies: [],
            dataPagination: {},
        }
    },
    methods:{
        loadMore() {
            let url = this.dataPagination.next_page_url ?? `/channels/comments/${this.comment.id}/replies`
            axios.get(url)
            .then(res => {
                this.dataPagination = res.data.data
                this.replies.push(...res.data.data.data)
            })
        }
    },
    computed:{
        unreadRepliesCount(){
            let count = this.comment.replies_count - this.replies.length
            return count > 0 ? count : null
        }
    }
}
</script>

<style scoped>

</style>
