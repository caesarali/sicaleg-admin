<template>
    <div class="d-flex justify-content-between mb-3" ref="pagination">
        <button class="btn btn-outline-secondary" :disabled="!page.prev" @click="pageOnChange(page.prev)">
            <i class="fas fa-arrow-left"></i>
            <span class="ml-1 d-none d-sm-inline">Sebelumnya</span>
        </button>
        <div class="d-inline-block bg-white border py-2 px-5" style="border-radius: 45px">
            Halaman {{ meta.current_page }} / {{ meta.last_page }}
        </div>
        <button class="btn btn-outline-secondary" :disabled="!page.next" @click="pageOnChange(page.next)">
            <span class="mr-1 d-none d-sm-inline">Selanjutnya</span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        links: Object,
        meta: Object,
        pageOnChange: Function
    },
    computed: {
        page() {
            return {
                first: this.links.first.substr(this.links.first.length - 1, 1),
                last: this.links.last.substr(this.links.last.length - 1, 1),
                next: this.links.next ? this.links.next.substr(this.links.next.length - 1, 1) : null,
                prev: this.links.prev ? this.links.prev.substr(this.links.prev.length - 1, 1) : null,
            }
        }
    }
}
</script>
