<template>
    <div class="mt-1 p-1">
        <div class="media">
            <a href="" class="mr-3">
                <avatar :size="30" :username="comment.user.name"></avatar>
            </a>
            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
                <div class="my-1 w-100">
                    <div class="d-flex align-items-center justify-content-start">
                        <a href="" class="mr-3" @click.prevent="isAddReply=!isAddReply" :class="{'btn btn-danger': isAddReply}">{{ isAddReply ? "Cancel" : "Add reply"}}</a>
                        <span class="text-muted">{{ comment.created_at_human }}</span>
                    </div>
                    <vote type="comment" :default_votes="comment.voters" :entity="comment"></vote>
                </div>
                <div v-if="authUser && isAddReply">
                    <input v-model="body" @keypress.enter="addReply" type="text"
                           class="form-control form-control-sm w-80">
                    <button @click="addReply" class="btn btn-sm btn-primary mr-2 mt-2">
                        <small>Add reply</small>
                    </button>
                </div>
                <replies :replies="replies"></replies>
                <div class="text-center">
                    <button v-if="unreadRepliesCount || this.dataPagination.next_page_url" @click="loadMore"
                            class="btn btn-success">
                        {{ unreadRepliesCount }} replies left
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Replies from "./Replies";

export default {
    name: "Comment",
    components: {Avatar, Replies},
    props: [
        'comment'
    ],
    data() {
        return {
            body: '',
            isAddReply: false,
            dataPagination: {},
            replies:[]
        }
    },
    methods: {
        loadMore() {
            let url = this.dataPagination.next_page_url ?? `/channels/comments/${this.comment.id}/replies`
            axios.get(url)
                .then(res => {
                    this.dataPagination = res.data.data
                    this.replies.push(...res.data.data.data)

                    const result = [];
                    const map = new Map();
                    for (const reply of this.replies) {
                        if(!map.has(reply.id)){
                            map.set(reply.id, true);    // set any value to Map
                            result.push(reply);
                        }
                    }

                    this.replies = [...result]
                })
        },
        addReply() {
            if (!this.body) {
                return alert('Please enter the reply')
            }
            axios.post(`/videos/comments/store`, {
                body: this.body,
                video_id: this.comment.media_id,
                comment_parent_id: this.comment.id
            })
                .then(res => {
                    // this.$emit('addComment', res.data.data)
                    this.replies.unshift(res.data.data)
                    this.body = ''
                    this.$emit('addNewReply', {comment_id: this.comment.id})
                    this.isAddReply = false
                })

        }
    },
    computed: {
        authUser() {
            return authUser

        },
        unreadRepliesCount() {
            let count = this.comment.replies_count - this.replies.length
            return count > 0 ? count : null
        }
    }
}
</script>

<style scoped>

</style>
