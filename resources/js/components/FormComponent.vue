<template>
    <div>
        <h3 class="text-center">Upload CSV File</h3>

        <h6 class="text-center">{{ process_status }}</h6>

        <div class="row">
            <div class="col-md-12">
                <div v-if="(progress && progress != 100)" class="text-center">
                    <div class="align-content-center" style="margin-right: 150px">
                        <progress-bar
                            :options="options"
                            :value="progress"
                        />
                    </div>
                </div>

                <div v-else>
                    <form @submit.prevent="uploadCsv" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" class="form-control" v-on:change="selectFile" required>
                        </div>

                        <button type="submit" class="float-right btn btn-primary" :disabled="loading" >Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoaderComponent from './LoaderComponent.vue';
import ProgressBar from 'vuejs-progress-bar'

const BASE_URL = 'http://localhost:8000/api';

export default {
    components: {
        LoaderComponent,
        ProgressBar
    },
    data() {
        return {
            csv: null,
            batch: {
                // "id": "93c6e511-e5a0-4e05-9974-9e94b3a9a188",
                // "name": "",
                // "totalJobs": 0,
                // "pendingJobs": 0,
                // "processedJobs": 0,
                // "progress": 0,
                // "failedJobs": 0,
                // "options": [],
                // "createdAt": "2021-06-27T20:09:19.000000Z",
                // "cancelledAt": null,
                // "finishedAt": null
            },
            batchId: null,
            loading: false,
            options: {
                progress: {
                    // color: '#2dbd2d',
                    // backgroundColor: '#333333',
                    // inverted: false
                },
                layout: {
                    height: 100,
                    width: 100,
                    type: 'cylinder'
                }
            }
        }
    },
    computed: {
        progress: function () {
            return this.batch ? this.batch.progress : 0
        },
        process_status: function () {
            if(this.progress) {
                if(this.progress >= 100) return 'File Uploaded. Upload another file?'
                if(this.progress > 0 && this.progress != 100) return 'Uploading ...'
                if(this.progress == 0) return 'Scheduled.'
            }
        }
    },
    created() {
        setInterval(() => {
            this.checkUploadDetails()
        }, 2000);

    },
    methods: {
        uploadCsv() {
            if(!this.validateCsv()) return

            this.loading = true

            let data = new FormData();
            data.append('csv_file', this.csv);

            let config = {
                headers: {'content-type': 'multipart/form-data'}
            }
            axios.post(BASE_URL + '/import-csv', data, config)
                .then(response => {
                    this.batch = response.data
                })
                .catch(err => {
                    alert(this.formatErrorMessage(err))
                })
                .finally(() => this.loading = false)
        },
        selectFile() {
            this.csv = event.target.files[0];
        },
        validateCsv() {
            if (!this.csv || this.csv.type !== "text/csv") {
                alert('Not a valid CSV file!')
                return false
            }
            return true;
        },
        checkUploadDetails() {
            if (this.batch && this.progress < 100) {
                let url = BASE_URL + '/batches/' + this.batch.id
                axios.get(url)
                    .then(response => (
                        this.batch = response.data
                    ))
                    .catch(err => {
                        console.log(err.response)
                        let message = this.formatErrorMessage(err) + '. Continue?'
                        if(!confirm(message)) {
                            this.batch = null
                        }
                    })
                    // .finally(() => this.loading = false)
            }
        },
        formatErrorMessage(err) {
            return err.response.message || err.response.data.message || err.message || 'Something went wrong!'
        }

    }
}
</script>
