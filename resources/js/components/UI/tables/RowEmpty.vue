<template>
    <tr>
        <td :colspan="colspan" nowrap class="text-center text-secondary">
            Data tidak ditemukan...
        </td>
    </tr>
</template>

<script>
export default {
    props: ['colspan']
}
</script>
