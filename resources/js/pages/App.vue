<template>
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload CSV</div>

                    <div class="card-body">
                        <form-component ></form-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormComponent from '../components/FormComponent.vue';

export default {
    name: 'App',
    components: {
        FormComponent
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
