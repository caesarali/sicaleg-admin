<template>
    <div class="lightbox" :class="show ? 'd-block' : 'd-none'">
        <span id="close" @click="close">&times;</span>
        <img class="image" v-lazy="image.src">
        <div class="caption">
            <span v-html="image.caption"></span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: false,
            image: {
                src: '',
                caption: '',
            }
        }
    },

    methods: {
        open(image) {
            this.image = image
            this.show = true
        },

        close() {
            this.show = false
        }
    }
}
</script>

<style lang="scss" scoped>
    .lightbox {
        position: fixed; /* Stay in place */
        z-index: 9999; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    .image {
        margin: auto;
        display: block;
        width: auto;
        max-width: 700px;
        max-height: calc(100vh - 280px);
    }

    .caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .image, .caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {transform:scale(0)}
        to {transform:scale(1)}
    }

    #close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    #close:hover,
    #close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px){
        .image {
            width: 100% !important;
        }
    }
</style>
