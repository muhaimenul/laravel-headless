<template>
    <div>
        <h3 class="text-center">Upload CSV File</h3>

        <h6 v-if="(progress && progress >= 100)" class="text-center">File imported. Upload another file?</h6>


        <div class="row">
            <div class="col-md-12">


                <div v-if="loading || (progress && progress != 100)" class="text-center">
                    <progress-bar
                        :options="options"
                        :value="progress"
                    />
                    <h6 class="text-center">File importing ...</h6>
                </div>

                <!--                <form @submit.prevent="uploadCsv" enctype="multipart/form-data">-->
                <!--                    <input type="file" class="form-control" v-on:change="selectFile">-->
                <!--                    <button class="btn btn-primary btn-block">Upload</button>-->
                <!--                </form>-->
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
        }
    },
    created() {
        setInterval(() => {
            this.checkUploadDetails()
        }, 2000);

    },
    methods: {
        uploadCsv() {
            this.validateCsv()

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
                    alert(err.response.message || err.response.data.message)
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
                    })
                    // .finally(() => this.loading = false)
            }
        }

    }
}
</script>
