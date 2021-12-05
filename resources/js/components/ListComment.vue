<template>
    <div class="card mt-2 p-5">
        <comment v-for="(comment, index) in comments" :comment="comment" :key="index"></comment>
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
            isAddComment: false
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
        }
    }
}
</script>

<style scoped>

</style>
