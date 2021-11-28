Vue.component('upload-video', {
    props: ['channel'],
    data() {
        return {
            selected: false,
            videos: [],
            progress: {},
            uploadData: [],
            intervals: {}
        }
    },

    methods: {
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
                        this.progress[nameVideo] = Math.ceil((event.loaded / event.total) * 100)
                        this.$forceUpdate()
                    }
                })
                    .then(({data}) => {
                        this.uploadData.push(data.data)
                    })

            })
            axios.all(uploaders)
                .then(() => {
                    this.videos = this.uploadData
                    this.videos.forEach((video) => {
                        this.intervals[video.id] = setInterval(() => {
                            axios.get(`/channels/videos/${video.id}`)
                                .then(res => {
                                    if (res.data.data.custom_properties.percentage === 100) {
                                        clearInterval(this.intervals[video.id])
                                    }
                                    this.videos = this.videos.map(v => {
                                        return v.id === res.data.data.id ? res.data.data : v
                                    })
                                })
                        }, 3000)
                    })
                })
        },
        getProgress(video, index) {
            if (video?.custom_properties?.percentage) {
                return video.custom_properties.percentage + '%'
            }
            let nameVideo = `${index}_${video.name}`
            let progress = this.progress[nameVideo]
            console.log('getProgress: ', progress)
            return progress + '%'
        },
        getResultProcess(video) {
            let percentage = video?.custom_properties?.percentage
            return percentage ? (percentage === 100 ? 'Video Processing complete' : 'Processing')
                : 'Uploading'

        }
    }
})
