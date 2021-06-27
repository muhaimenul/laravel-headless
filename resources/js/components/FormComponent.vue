<template>
    <div>
        <h3 class="text-center">Upload CSV File</h3>


        <div class="row">
            <div class="col-md-12">


                <div>
                    <progress-bar
                        :options="options"
                        :value="progress"
                    />
                </div>

                <!--                <form @submit.prevent="uploadCsv" enctype="multipart/form-data">-->
                <!--                    <input type="file" class="form-control" v-on:change="selectFile">-->
                <!--                    <button class="btn btn-primary btn-block">Upload</button>-->
                <!--                </form>-->


                <form @submit.prevent="uploadCsv" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" v-on:change="selectFile" required>
                    </div>

                    <button type="submit" class="float-right btn btn-primary">Upload</button>
                </form>
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
            batch: null,
            batchId: null,
            loading: false,
            progress: 0,
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
        // progress: function () {
        //     return 50
        // }
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
            console.log(this.csv)
            let config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            axios
                .post(BASE_URL+'/import-csv', data, config)
                .then(response => (
                    console.log(response.data)
                ))
                .catch(err => {
                    console.log(err.response)
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
            if (this.progress < 100) {
                this.progress += 5;
            }
        }

    }
}
</script>
