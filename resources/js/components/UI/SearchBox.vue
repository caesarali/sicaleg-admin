<template>
    <div class="form-inline">
        <div class="input-group app-shadow">
            <input type="search" v-model="$root.keywords" placeholder="Search" aria-label="Search" class="form-control form-control-navbar border-0">
            <div class="input-group-append">
                <div class="input-group-text bg-white border-0">
                    <i class="fa fa-search" v-if="!$root.isSearching"></i>
                    <i class="fas fa-spinner fa-spin text-secondary" v-else></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
