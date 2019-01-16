<template>
    <div class="card">
        <div class="card-header border-0">
            <badge-default>
                {{ name }}
            </badge-default>
            <a href="#" class="text-secondary ml-auto float-right">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr v-for="x in 10" :key="x">
                        <td class="text-center" width="1%">{{ x }}.</td>
                        <td>Makassar</td>
                        <td class="text-right">
                            <a href="#" class="text-secondary ml-2">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        locations: Array
    },
    methods: {

    }
}
</script>
