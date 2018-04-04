<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="upload-btn-wrapper">
                    <button class="btn btn-success">Upload pdf</button>
                    <input type="file" accept=".pdf" v-on:change="uploadPdfHandler">
                </div>
            </div>
        </div>
        <div v-if="data.total">
            <div class="row thumbnails">
                <div class="col-3" v-for="pdf in data.pdfs[data.currentPage]">
                    <a v-on:click.prevent="openPdf(pdf)" href="#">
                        <img :src="pdf.thumb" alt="">
                    </a>
                </div>
            </div>

            <div class="row">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-if="data.currentPage > 1" class="page-item">
                            <a v-on:click.prevent="prevPage()" class="page-link" href="#">Previous</a>
                        </li>
                        <li
                                v-for="page in data.totalPages"
                                v-on:click.prevent="setPage(page)"
                                class="page-item"
                                :class="{active: page == data.currentPage}"
                        >
                            <a class="page-link" href="#">{{ page }} </a>
                        </li>
                        <li v-if="data.currentPage < data.totalPages" class="page-item">
                            <a v-on:click.prevent="nextPage()" class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- use the modal component, pass in the prop -->
            <modal v-if="show.pdf" @close="show.pdf = false">
                <iframe slot="body" :src="data.activePdf.url"></iframe>
                <h3 slot="header">custom header</h3>
            </modal>
        </div>
        <div v-else>
            <p>No pdfs :(</p>
        </div>

    </div>

</template>

<script>
    export default {
        props: ['thumbsPerPage'],
        data() {
            return {
                show: {
                    pdf: false
                },
                data: {
                    perPage: 0,
                    currentPage: 1,
                    total: 0,
                    totalPages: null,
                    pdfs: {},
                    activePdf: {}
                },
                urls: {
                    pdfs: '/v1/pdfs/',
                },
            }
        },
        mounted() {
            this.data.perPage = this.thumbsPerPage;
            this._getForPage();
        },
        methods: {
            uploadPdfHandler(e) {

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    console.error('no file');
                    return;
                }

                let pdf = files.item(0);
                if (pdf.type !== 'application/pdf') {
                    console.error('no pdf');
                    return;
                }

                this._uploadPdf(files.item(0));

            },
            _uploadPdf(pdf) {

                let data = new FormData(),
                    config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                data.append('pdf', pdf);

                axios.post(this.urls.pdfs, data, config)
                    .then(result => {

                        let isLastPage = this.data.currentPage === this.data.totalPages,
                            currentPagePdfs = this.data.pdfs[this.data.currentPage];

                        if (result.data.pdf.id) {

                            this.data.total += 1;

                            if (isLastPage && this.data.perPage > currentPagePdfs.length) {

                                this.data.pdfs[this.data.currentPage].push(result.data.pdf);

                            } else if (isLastPage) {

                                this.data.totalPages += 1;

                            }

                            return this.$forceUpdate();
                        }

                        console.error('fail to upload');

                    }).catch(result => {

                    console.error('error catched - fail to upload');

                });

            },
            _getForPage() {
                axios.get(this.urls.pdfs + '?page=' + this.data.currentPage)
                    .then(result => {

                        if (result.data.pdfs) {

                            this.data.total = result.data.pdfs.total;
                            this.data.totalPages = result.data.pdfs.last_page;
                            this.data.pdfs[this.data.currentPage] = result.data.pdfs.data;

                            return this.$forceUpdate();
                        }

                        console.error('fail to get for page');

                    }).catch(result => {

                    console.error('error catched - fail to get for page');

                });
            },
            openPdf(pdf) {
                this.data.activePdf = pdf;
                this.show.pdf = true;
            },
            nextPage() {
                this.data.currentPage += 1;
                this._getForPage();
            },
            prevPage() {
                this.data.currentPage -= 1;
                this._getForPage();
            },
            setPage(page) {
                this.data.currentPage = page;
                this._getForPage();
            }
        }
    }
</script>
