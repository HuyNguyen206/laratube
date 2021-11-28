Vue.component('upload-video', {
    props:['channel'],
    data(){
        return {
            selected:false,
            videos: [],
            progress: {}
        }
    },

    methods:{
        upload() {
            this.selected = true
            this.videos = Array.from(this.$refs.videos.files)
            console.log(this.videos)
            const uploaders = this.videos.map((video, index) => {
                let nameVideo = `${index}_${video.name}`
                this.progress[nameVideo] = 0
                const form = new FormData()
                form.append('video', video)
                form.append('title', video.name)
                return axios.post(`/channels/upload-video/${this.channel.id}`, form, {
                    onUploadProgress: (event) => {
                        console.log(event)
                        this.progress[nameVideo] = Math.ceil((event.loaded / event.total)* 100)
                        this.$forceUpdate()
                    }
                })
            })
        },
        getProgress(video, index) {
            let nameVideo = `${index}_${video.name}`
            let progress = this.progress[nameVideo] ?? 0
            console.log('getProgress: ',progress)
            return progress + '%'
        }
    }
})
