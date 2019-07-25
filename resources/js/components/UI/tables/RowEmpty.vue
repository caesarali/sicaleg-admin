<template>
    <tr>
        <td :colspan="colspan" nowrap class="text-center text-secondary">
            {{ message }}
        </td>
    </tr>
</template>

<script>
export default {
    props: ['colspan'],
    computed: {
        message() {
            return this.$root.isLoading ? 'Memuat data...' : 'Data tidak ditemukan...'
        }
    }
}
</script>
